<?php

namespace App\Repositories;

use App\Tweet;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Cache;
use DB;

class Statistics
{
    public static function getUsersWithMostTweets()
    {
        return Cache::remember('usersWithMostTweets', 1, function () {
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
            ->groupBy('id')
            ->orderBy('tweets_count', 'desc')
            ->limit(50)
            ->get();
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