<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

class CountdownController extends Controller
{
    public function __invoke() {
        if (Carbon::now()->gte(Carbon::parse(config('hmr.start_time')))) {
            return redirect('/live');
        }

        return view('countdown');
    }
}
