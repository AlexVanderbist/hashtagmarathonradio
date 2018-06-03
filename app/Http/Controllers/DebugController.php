<?php

namespace App\Http\Controllers;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use RuntimeException;

class DebugController extends Controller
{
    public function __invoke() {
        Bugsnag::notifyException(new RuntimeException("Test error"));
        return (new \App\Events\DashboardUpdate())->statistics;
    }
}
