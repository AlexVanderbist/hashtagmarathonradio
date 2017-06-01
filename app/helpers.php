<?php

use Carbon\Carbon;

function getCurrentDjId(): int
{
    $now = Carbon::now();

    $dj = collect(config('schedule'))
        ->map(function ($schedule) {
            $schedule['start'] = new Carbon($schedule['start']);
            $schedule['stop'] = new Carbon($schedule['stop']);

            return $schedule;
        })
        ->where('start', '<=', $now)
        ->where('stop', '>', $now)
        ->first();

    return $dj['id'] ?? -1;
}