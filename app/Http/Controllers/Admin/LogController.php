<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // 1. Search Query Filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('user_name', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // 2. Action Type Filter
        if ($request->filled('action_type')) {
            $query->where('action', $request->input('action_type'));
        }

        // Paginate results safely
        $logs = $query->paginate(15)->withQueryString();

        // Unique actions extracted for the filter dropdown
        $distinctActions = ActivityLog::distinct()->pluck('action');

        return view('admin.logs', compact('logs', 'distinctActions'));
    }
}
