<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;

class EntriesController extends Controller
{
    public function index(Request $request)
    {
        $registers    = config('registers');
        $registerType = $request->get('register_type', '');
        $fromDate     = $request->get('from_date', '');
        $toDate       = $request->get('to_date', '');
        $status       = $request->get('status', '');

        $user  = auth()->user();

        $query = Submission::with(['user.designation', 'user.department', 'reviewer'])
            ->orderByRaw("JSON_UNQUOTE(JSON_EXTRACT(form_data, '$.sr_no')) + 0 ASC");

        // Scope by role
        if ($user->hasRole('user')) {
            $query->where('user_id', $user->id);
        } elseif ($user->hasRole('manager')) {
            $functionId = $user->function_id;
            $query->whereHas('user', function ($q) use ($functionId) {
                $q->where('function_id', $functionId);
            });
        }

        if ($registerType) $query->where('register_type', $registerType);
        if ($status)       $query->where('status', $status);
        if ($fromDate)     $query->whereDate('created_at', '>=', $fromDate);
        if ($toDate)       $query->whereDate('created_at', '<=', $toDate);

        $entries = $query->paginate(20)->withQueryString();

        $fields = $registerType
            ? config("registers.{$registerType}.fields", [])
            : [];

        return view('entries.table', compact(
            'entries', 'registers', 'registerType',
            'fields', 'fromDate', 'toDate', 'status'
        ));
    }
}