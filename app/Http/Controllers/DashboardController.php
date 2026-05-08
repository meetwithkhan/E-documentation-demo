<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin'))   return redirect()->route('admin.dashboard');
        if ($user->hasRole('manager')) return redirect()->route('manager.home');

        return redirect()->route('user.dashboard');
    }
}