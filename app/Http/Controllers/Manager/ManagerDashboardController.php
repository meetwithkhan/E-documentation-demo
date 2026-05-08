<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Notifications\SubmissionStatusNotification;

class ManagerDashboardController extends Controller
{
    /**
     * Get the function ID of the logged-in manager
     */
    private function getManagerFunctionId(): ?int
    {
        return auth()->user()->function_id;
    }

    /**
     * Base query — only submissions from users in same function
     */
    private function scopedQuery()
    {
        $functionId = $this->getManagerFunctionId();

        return Submission::with('user', 'reviewer')
            ->whereHas('user', function ($q) use ($functionId) {
                $q->where('function_id', $functionId);
            });
    }

    public function index()
    {
        $functionId = $this->getManagerFunctionId();

        // Warn if manager has no function assigned
        if (!$functionId) {
            return view('manager.dashboard', [
                'pending'  => collect(),
                'approved' => collect(),
                'rejected' => collect(),
                'stats'    => ['total' => 0, 'pending' => 0, 'approved' => 0, 'rejected' => 0],
                'noFunction' => true,
            ]);
        }

        $pending  = $this->scopedQuery()->where('status', 'pending')->latest()->get();
        $approved = $this->scopedQuery()->where('status', 'approved')->latest()->get();
        $rejected = $this->scopedQuery()->where('status', 'rejected')->latest()->get();

        $stats = [
            'pending'  => $this->scopedQuery()->where('status', 'pending')->count(),
            'approved' => $this->scopedQuery()->where('status', 'approved')->count(),
            'rejected' => $this->scopedQuery()->where('status', 'rejected')->count(),
            'total'    => $this->scopedQuery()->count(),
        ];

        return view('manager.dashboard', compact(
            'pending', 'approved', 'rejected', 'stats'
        ));
    }

    public function approve(Request $request, Submission $submission)
    {
        $this->authorizeSubmission($submission);

        $reviewFields = config("registers.{$submission->register_type}.review_fields", []);

        $rules = ['review_note' => 'nullable|string|max:500'];
        foreach ($reviewFields as $field) {
            $rule = $field['required'] ? 'required' : 'nullable';
            $rule .= $field['type'] === 'date' ? '|date' : '|string|max:255';
            $rules[$field['name']] = $rule;
        }

        $validated   = $request->validate($rules);
        $reviewNote  = $validated['review_note'] ?? null;
        unset($validated['review_note']);

        $submission->update([
            'status'      => 'approved',
            'reviewed_by' => auth()->id(),
            'review_data' => $validated,
            'review_note' => $reviewNote,
            'reviewed_at' => now(),
        ]);
        // After approve Notify user (database notification — instant)
        $submission->user->notify(
            new SubmissionStatusNotification(
                $submission->fresh(),
                'Your ' . $submission->registerName() . ' entry has been approved. ✓',
                'success'
            )
        );

        return back()->with('success', 'Entry approved successfully.');
    }

    public function reject(Request $request, Submission $submission)
    {
        $this->authorizeSubmission($submission);

        $request->validate(['review_note' => 'required|string|max:500']);

        $submission->update([
            'status'      => 'rejected',
            'reviewed_by' => auth()->id(),
            'review_note' => $request->review_note,
            'reviewed_at' => now(),
        ]);
        // After reject Notify user (database notification — instant)
        $submission->user->notify(
            new SubmissionStatusNotification(
                $submission->fresh(),
                'Your ' . $submission->registerName() . ' entry has been rejected.',
                'error'
            )
        );


        return back()->with('success', 'Entry rejected.');
    }

    public function requestEdit(Request $request, Submission $submission)
    {
        $this->authorizeSubmission($submission);

        $request->validate(['review_note' => 'required|string|max:500']);

        $submission->update([
            'status'      => 'edit_requested',
            'reviewed_by' => auth()->id(),
            'review_note' => $request->review_note,
            'reviewed_at' => now(),
        ]);
        // After requestEdit Notify user (database notification — instant)
        $submission->user->notify(
            new SubmissionStatusNotification(
                $submission->fresh(),
                'Changes requested for your ' . $submission->registerName() . ' entry.',
                'warning'
            )
        );

        return back()->with('success', 'Edit request sent to user.');
    }

    /**
     * Make sure manager can only act on submissions
     * from users in the same function
     */
    private function authorizeSubmission(Submission $submission): void
    {
        $functionId = $this->getManagerFunctionId();

        $sameFunction = $submission->user->function_id === $functionId;

        if (!$sameFunction) {
            abort(403, 'You are not authorized to review this submission.');
        }
    }
}