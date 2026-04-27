<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'   => User::count(),
            'total_roles'   => Role::count(),
            'admins'        => User::role('admin')->count(),
            'managers'      => User::role('manager')->count(),
        ];

        $recentUsers = User::with('roles')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers'));
    }
}