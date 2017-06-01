<?php

namespace App\Repositories;

use App\Tweet;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class Statistics
{
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