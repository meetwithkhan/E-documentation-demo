<?php

namespace App\Jobs;

use App\Mail\PendingTaskReminderMail;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendPendingReminderToManagers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public function handle(): void
    {
        $managers = User::role('manager')
            ->whereNotNull('email')
            ->whereNotNull('function_id')
            ->get();

        if ($managers->isEmpty()) {
            Log::info('[ManagerReminder] No managers found.');
            return;
        }

        foreach ($managers as $manager) {
            $pending = Submission::with('user')
                ->where('status', 'pending')
                ->whereHas('user', fn($q) =>
                    $q->where('function_id', $manager->function_id)
                )
                ->latest()
                ->get();

            if ($pending->isEmpty()) {
                Log::info("[ManagerReminder] No pending for {$manager->email} — skipped.");
                continue;
            }

            try {
                Mail::to($manager->email)
                    ->send(new PendingTaskReminderMail(
                        $manager,
                        $pending,
                        $pending->count()
                    ));

                Log::info("[ManagerReminder] Sent to {$manager->email} — {$pending->count()} pending.");

            } catch (\Exception $e) {
                Log::error("[ManagerReminder] Failed {$manager->email}: " . $e->getMessage());
            }
        }
    }
}