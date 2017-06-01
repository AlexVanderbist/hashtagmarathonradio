<?php

namespace App\Http\Controllers;

use App\Repositories\Statistics;

class DashboardController extends Controller
{
    public function index() {
        $statistics = Statistics::getDashboardStatistics(true);

        return view('dashboard', compact('statistics'));
    }
}
