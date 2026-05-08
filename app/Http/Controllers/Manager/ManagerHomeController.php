<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Submission;

class ManagerHomeController extends Controller
{
    public function index()
    {
        $functionId = auth()->user()->function_id;

        // Base query scoped to same function users
        $base = Submission::whereHas('user', function ($q) use ($functionId) {
            $q->where('function_id', $functionId);
        });

        $stats = [
            'pending'  => (clone $base)->where('status', 'pending')->count(),
            'approved' => (clone $base)->where('status', 'approved')->count(),
            'rejected' => (clone $base)->where('status', 'rejected')->count(),
            'total'    => (clone $base)->count(),
        ];

        return view('manager.home', compact('stats'));
    }
}