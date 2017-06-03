<?php

namespace App\Repositories;

use App\Tweet;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Cache;
use DB;

class Statistics
{
    public static function getDashboardStatistics(bool $fromCache = false): array
    {
        if ($fromCache && Cache::has('dashboardStatistics')) {
            return Cache::get('dashboardStatistics');
        }

        $startTime = microtime(true);

        $statistics = [
            'totalTweets' => Tweet::count(),
            'totalUsers' => User::count(),
            'tweetsPerMinute' => DB::table('tweets')->where('tweeted_at', '>', Carbon::now()->subMinute())->count(),
            'usersWithMostTweets' => self::getUsersWithMostTweets(),
            'lastWordOccurrences' => self::getWordOccurrences(Carbon::parse('30 minutes ago'), 10),
            'allTimeWordOccurrences' => self::getAllTimeWordOccurrences(),
            'tweetsPerDj' => self::getTweetsPerDj(),
            'processingTime' => round(microtime(true) - $startTime, 2),
        ];

        Cache::forever('dashboardStatistics', $statistics);

        return $statistics;
    }

    public static function getTweetsPerDj()
    {
        return collect(config('hmr.djs'))->map(function ($dj) {
            $count = DB::table('tweets')->where('dj', $dj['id'])->count();

            return $dj + ['count' => $count];
        });
    }

    public static function getUsersWithMostTweets()
    {
        return Cache::remember('usersWithMostTweets', 5, function () {
            return self::fetchUsersWithMostTweets();
        });
    }

    public static function cacheUsersWithMostTweets()
    {
        Cache::forever('usersWithMostTweets', self::fetchUsersWithMostTweets());
    }

    private static function fetchUsersWithMostTweets()
    {
        return DB::table('users')
            ->select('users.screen_name', DB::raw('count(*) as tweets_count'))
            ->join('tweets', 'users.id', 'tweets.user_id')
            ->groupBy('users.id')
            ->orderBy('tweets_count', 'desc')
            ->limit(50)
            ->get();
    }

    public static function getAllTimeWordOccurrences()
    {
        return Cache::remember('allTimeWordOccurrences', 5, function () {
            return self::getWordOccurrences();
        });
    }

    public static function cacheAllTimeWordOccurrences()
    {
        Cache::forever('allTimeWordOccurrences', self::getWordOccurrences());
    }

    public static function getWordOccurrences(?Carbon $since = null, int $limit = 100)
    {
        $wordOccurrences = collect();

        $tweets = Tweet::query()
            ->when($since, function ($query) use ($since) {
                return $query->where('tweeted_at', '>=', $since);
            })
            ->get();

        $tweets->each(function (Tweet $tweet) use ($wordOccurrences) {

            self::extractCommonWords($tweet->text)
                ->each(function ($count, $word) use ($wordOccurrences) {

                    $totalWordCount = (int) $wordOccurrences->get($word) + (int) $count;
                    $wordOccurrences->put($word, $totalWordCount);

                });
        });

        return $wordOccurrences
            ->map(function ($count, $word) {
                return ['word' => $word, 'count' => $count];
            })
            ->sortByDesc('count')
            ->values()
            ->take($limit);
    }

    public static function extractCommonWords(string $string): Collection
    {
        $string = trim($string);
        $string = strtolower($string);

        // only take alphabet characters and keep the spaces, dashes and hashtags
        $string = preg_replace('/[^a-zA-Z\d \-\_@#]/', '', $string);

        $pattern = '/[ \n]/';
        $matchWords = collect(preg_split($pattern, $string));

        return $matchWords
            ->map(function ($word) {
                return trim($word);
            })
            ->filter(function ($word) {
                return self::shouldCountWord($word);
            })
            ->groupBy(function ($word) {
                return $word;
            })
            ->map(function ($groupedWords) {
                return $groupedWords->count();
            });
    }

    private static function shouldCountWord(string $word): bool
    {
        if (substr($word, 0, 4) === 'http') {
            return false;
        }

        if(empty($word)) {
            return false;
        }

        if(in_array($word, config('ignored-words'))) {
            return false;
        }

        if(strlen($word) <= 3) {
            return false;
        }

        return true;
    }
}