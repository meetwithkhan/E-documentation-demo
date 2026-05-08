<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Submission;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'pending'  => Submission::where('user_id', $user->id)->where('status', 'pending')->count(),
            'approved' => Submission::where('user_id', $user->id)->where('status', 'approved')->count(),
            'rejected' => Submission::where('user_id', $user->id)->where('status', 'rejected')->count(),
        ];

        $editRequests = Submission::where('user_id', $user->id)
            ->where('status', 'edit_requested')
            ->latest()->get();

        return view('user.dashboard', compact('user', 'stats', 'editRequests'));
    }
}