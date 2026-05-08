<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;
use App\Notifications\NewSubmissionNotification;
use App\Models\User;

class SubmissionController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $submissions = Submission::where('user_id', $userId)
            ->latest()->paginate(10);

        $stats = [
            'pending'  => Submission::where('user_id', $userId)->where('status', 'pending')->count(),
            'approved' => Submission::where('user_id', $userId)->where('status', 'approved')->count(),
            'rejected' => Submission::where('user_id', $userId)->where('status', 'rejected')->count(),
        ];

        return view('submissions.index', compact('submissions', 'stats'));
    }
    public function create()
    {
        $registers = config('registers');
        return view('submissions.create', compact('registers'));
    }

    public function store(Request $request)
    {
        // Check signature
        if (!auth()->user()->hasSignature()) {
            return redirect()->route('profile.edit')
                ->with('error', 'You must upload your signature before submitting any entry. Please upload it in your profile.');
        }
        
        $request->validate([
            'register_type' => 'required|string|in:' . implode(',', array_keys(config('registers'))),
        ]);

        $registerType = $request->register_type;
        $fields       = config("registers.{$registerType}.fields", []);

        $rules = [];
        foreach ($fields as $field) {
            // Skip auto fields
            if (!empty($field['auto_user'])) continue;
            if ($field['name'] === 'sr_no') continue;

            $rule = $field['required'] ? 'required' : 'nullable';
            $rule .= match($field['type']) {
                'date'   => '|date',
                'time'   => '|date_format:H:i',
                'number' => '|numeric',
                default  => '|string|max:500',
            };
            $rules[$field['name']] = $rule;
        }

        $validated = $request->validate($rules);

        // Auto-fill sr_no
        foreach ($fields as $field) {
            if ($field['name'] === 'sr_no') {
                $validated['sr_no'] = Submission::nextSrNo($registerType);
                break;
            }
        }

        // Auto-fill auto_user fields
        foreach ($fields as $field) {
            if (!empty($field['auto_user'])) {
                $validated[$field['name']] = auth()->user()->name;
            }
        }

        $submission = Submission::create([
            'user_id'       => auth()->id(),
            'register_type' => $registerType,
            'form_data'     => $validated,
        ]);

        // Notify managers in same function (database notification — instant)
        $managers = User::role('manager')
            ->where('function_id', auth()->user()->function_id)
            ->get();

        foreach ($managers as $manager) {
            $manager->notify(new NewSubmissionNotification($submission));
        }

        return redirect()->route('submissions.index')
            ->with('success', "Entry submitted successfully. Waiting for manager's approval.");
    }

    public function destroy(Submission $submission)
    {
        if ($submission->user_id !== auth()->id()) abort(403);
        $submission->delete();
        return back()->with('success', 'Entry deleted.');
    }

    public function edit(Submission $submission)
    {
        if ($submission->user_id !== auth()->id()) abort(403);
        if ($submission->status !== 'edit_requested') abort(403);

        $registers = config('registers');
        return view('submissions.edit', compact('submission', 'registers'));
    }

    public function update(Request $request, Submission $submission)
    {
        if ($submission->user_id !== auth()->id()) abort(403);
        if ($submission->status !== 'edit_requested') abort(403);

        $registerType = $submission->register_type;
        $fields       = config("registers.{$registerType}.fields", []);

        $rules = [];
        foreach ($fields as $field) {
            if ($field['name'] === 'remarks') continue; // remarks locked
            $rule = $field['required'] ? 'required' : 'nullable';
            $rule .= match($field['type']) {
                'date'   => '|date',
                'time'   => '|date_format:H:i',
                'number' => '|numeric',
                default  => '|string|max:500',
            };
            $rules[$field['name']] = $rule;
        }

        $validated = $request->validate($rules);

        // Keep old remarks + append manager note as new remarks
        $oldData           = $submission->form_data;
        $oldRemarks        = $oldData['remarks'] ?? '';
        $managerNote       = $submission->review_note;
        $validated['remarks'] = trim($oldRemarks . ($oldRemarks ? ' | ' : '') . '[Edit requested: ' . $managerNote . ']');

        $submission->update([
            'form_data'   => array_merge($oldData, $validated),
            'status'      => 'pending',
            'review_note' => null,
            'reviewed_by' => null,
            'reviewed_at' => null,
        ]);

        return redirect()->route('submissions.index')
            ->with('success', 'Entry updated and resubmitted.');
    }
}