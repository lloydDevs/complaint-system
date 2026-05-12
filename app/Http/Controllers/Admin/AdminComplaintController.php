<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Services\AdminComplaintService;
use App\Services\AnalyticsService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminComplaintController extends Controller
{
    protected $analytics;

    public function __construct(
        protected AdminComplaintService $adminService, AnalyticsService $analytics
    ) {
        $this->analytics = $analytics;
    }

    public function analytics()
    {
        $statusData = $this->analytics->getStatusDistribution();

        $months = [];
        $monthlyCounts = [];

        // Loop through the last 6 months
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);

            // 1. Create the Label (e.g., "Apr")
            $months[] = $date->format('M');

            // 2. Query the DB directly for this specific Month and Year
            // This bypasses any service key-mismatch issues
            $count = Complaint::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();

            $monthlyCounts[] = $count;
        }

        // Agency Logic (remains the same)
        $agencies = Complaint::select('agency', \DB::raw('count(*) as total'))
            ->whereNotNull('agency')
            ->groupBy('agency')
            ->orderBy('total', 'desc')
            ->get();

        $agencyData = [
            'labels' => $agencies->pluck('agency')->toArray(),
            'counts' => $agencies->pluck('total')->toArray(),
        ];

        return view('admin.analytics', compact(
            'statusData',
            'months',
            'monthlyCounts',
            'agencyData'
        ));
    }

    public function index(Request $request)
    {
        $agencies = Complaint::distinct()->pluck('agency')->filter()->sort();
        $query = Complaint::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%");
            });
        }
        // 1. Filter by Specific Date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // 2. Filter by Month
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        // 3. Filter by Year
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        // 4. Filter by Agency (Partial Search)
        if ($request->filled('agency')) {
            $query->where('agency', 'like', '%'.$request->agency.'%');
        }
        $query->when($request->status, function ($q, $status) {
            $q->where('status', $status);
        });

        $complaints = $query->latest()->paginate(10);

        // Don't forget to pass agencies for the dropdown!
        $agencies = Complaint::distinct()->pluck('agency');
        $data = $this->adminService->getDashboardStats();

        return view('admin.dashboard', compact('data', 'complaints', 'agencies'));
    }

    public function show(Complaint $complaint)
    {
        // If the admin opens a new complaint, mark it as viewed
        if ($complaint->status === 'pending') {
            $complaint->update(['status' => 'viewed']);
        }

        return view('admin.show', compact('complaint'));
    }

    public function update(Request $request, Complaint $complaint)
    {
        $request->validate(['admin_response' => 'required|string|min:10']);

        $this->adminService->updateComplaintStatus($complaint, $request->admin_response);

        return redirect()->route('admin.dashboard')->with('success', 'Complaint resolved successfully.');
    }
}
