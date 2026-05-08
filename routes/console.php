<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

use App\Jobs\SendPendingReminderToManagers;
use App\Jobs\SendDailyDigestToUsers;
use Illuminate\Support\Facades\Schedule;



Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');



// ── 5 PM Daily Email Digest ───────────────────────────────────────────
Schedule::job(new SendPendingReminderToManagers, 'emails')
    ->weekdays()
    ->at('17:00')
    ->withoutOverlapping()
    ->onSuccess(fn() => \Log::info('Manager reminders dispatched at ' . now()))
    ->onFailure(fn() => \Log::error('Manager reminders FAILED at ' . now()));

Schedule::job(new SendDailyDigestToUsers, 'emails')
    ->weekdays()
    ->at('17:00')
    ->withoutOverlapping()
    ->onSuccess(fn() => \Log::info('User digests dispatched at ' . now()))
    ->onFailure(fn() => \Log::error('User digests FAILED at ' . now()));