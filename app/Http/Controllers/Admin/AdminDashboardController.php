<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Submission;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'pending'     => Submission::where('status', 'pending')->count(),
            'approved'    => Submission::where('status', 'approved')->count(),
            'rejected'    => Submission::where('status', 'rejected')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}