<?php

namespace App\Jobs;

use App\Mail\UserDailyDigestMail;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendDailyDigestToUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public function handle(): void
    {
        $users = User::role('user')
            ->whereNotNull('email')
            ->get();

        if ($users->isEmpty()) {
            Log::info('[UserDigest] No users found.');
            return;
        }

        foreach ($users as $user) {
            $pending = Submission::where('user_id', $user->id)
                ->where('status', 'pending')
                ->count();

            $editRequests = Submission::where('user_id', $user->id)
                ->where('status', 'edit_requested')
                ->get();

            if ($pending === 0 && $editRequests->isEmpty()) {
                Log::info("[UserDigest] Nothing to send for {$user->email} — skipped.");
                continue;
            }

            try {
                Mail::to($user->email)
                    ->send(new UserDailyDigestMail($user, $pending, $editRequests));

                Log::info("[UserDigest] Sent to {$user->email}.");

            } catch (\Exception $e) {
                Log::error("[UserDigest] Failed {$user->email}: " . $e->getMessage());
            }
        }
    }
}