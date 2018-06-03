<?php

namespace App\Http\Controllers;

class DebugController extends Controller
{
    public function __invoke() {
        return (new \App\Events\DashboardUpdate())->statistics;
    }
}
