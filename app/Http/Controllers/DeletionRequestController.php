<?php

namespace App\Http\Controllers;

use App\Models\DeletionRequest;
use App\Models\User;
use Illuminate\Http\Request;

class DeletionRequestController extends Controller
{
    // Manager submits a deletion request
    public function store(Request $request)
    {
        $request->validate([
            'target_user_id' => 'required|exists:users,id',
            'reason'         => 'required|string|max:500',
        ]);

        $target = User::findOrFail($request->target_user_id);

        if (!auth()->user()->hasRole('manager')) {
            return back()->with('error', 'Unauthorized.');
        }

        if (!$target->hasRole('manager')) {
            return back()->with('error', 'This user does not require deletion approval.');
        }

        if ($target->id === auth()->id()) {
            return back()->with('error', 'You cannot request deletion of yourself.');
        }

        $existing = DeletionRequest::where('target_user_id', $target->id)
            ->where('status', 'pending')->first();

        if ($existing) {
            return back()->with('error', 'A deletion request for this user is already pending.');
        }

        $deletionRequest = DeletionRequest::create([
            'requested_by'   => auth()->id(),
            'target_user_id' => $target->id,
            'reason'         => $request->reason,
        ]);

        // Send email to ALL admin users
        $admins = User::role('admin')->whereNotNull('email')->get();

        foreach ($admins as $admin) {
            try {
                \Mail::to($admin->email)->send(
                    new \App\Mail\DeletionRequestMail($deletionRequest)
                );
            } catch (\Exception $e) {
                \Log::error('Failed to send deletion request email to ' . $admin->email . ': ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Deletion request submitted. Admins have been notified by email.');
    }

    // Admin approves deletion
    public function approve(Request $request, DeletionRequest $deletionRequest)
    {
        if (!auth()->user()->hasRole('admin')) abort(403);

        $request->validate(['review_note' => 'nullable|string|max:500']);

        $user = $deletionRequest->targetUser;

        if ($user) {
            $user->delete();
        }

        $deletionRequest->update([
            'status'      => 'approved',
            'reviewed_by' => auth()->id(),
            'review_note' => $request->review_note,
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'User deleted successfully.');
    }

    // Admin rejects deletion
    public function reject(Request $request, DeletionRequest $deletionRequest)
    {
        if (!auth()->user()->hasRole('admin')) abort(403);

        $request->validate(['review_note' => 'required|string|max:500']);

        $deletionRequest->update([
            'status'      => 'rejected',
            'reviewed_by' => auth()->id(),
            'review_note' => $request->review_note,
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Deletion request rejected.');
    }

    // Admin views all requests
    public function index()
    {
        if (!auth()->user()->hasRole('admin')) abort(403);

        $pending  = DeletionRequest::with('requester', 'targetUser')
                        ->where('status', 'pending')->latest()->get();
        $reviewed = DeletionRequest::with('requester', 'targetUser', 'reviewer')
                        ->whereIn('status', ['approved', 'rejected'])
                        ->latest()->take(20)->get();

        return view('deletion-requests.index', compact('pending', 'reviewed'));
    }
}