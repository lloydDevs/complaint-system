<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
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
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M');
            $count = Complaint::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
            $monthlyCounts[] = $count;
        }

        // --- Linear Regression Prediction ---
        $n = count($monthlyCounts);
        $x = range(1, $n); //

        $sumX = array_sum($x);
        $sumY = array_sum($monthlyCounts);
        $sumXY = 0;
        $sumX2 = 0;

        for ($i = 0; $i < $n; $i++) {
            $sumXY += $x[$i] * $monthlyCounts[$i];
            $sumX2 += $x[$i] * $x[$i];
        }

        // slope (m) and intercept (b) of y = mx + b
        $m = ($n * $sumXY - $sumX * $sumY) / ($n * $sumX2 - $sumX * $sumX);
        $b = ($sumY - $m * $sumX) / $n;

        // Predict next 3 months
        $predictionMonths = [];
        $predictionCounts = [];
        for ($i = 1; $i <= 3; $i++) {
            $futureDate = Carbon::now()->addMonths($i);
            $predictionMonths[] = $futureDate->format('M');
            $predicted = round($m * ($n + $i) + $b);
            $predictionCounts[] = max(0, $predicted); // no negative counts
        }
        // ---

        $department = Complaint::select('department', DB::raw('count(*) as total'))
            ->whereNotNull('department')
            ->groupBy('department')
            ->orderBy('total', 'desc')
            ->get();

        $departmentData = [
            'labels' => $department->pluck('department')->toArray(),
            'counts' => $department->pluck('total')->toArray(),
        ];

        // Log Analytics Generation
        ActivityLog::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'action' => 'View Analytics',
            'description' => 'Admin generated complaint distributions and linear regression trend modeling forecasts.',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return view('admin.analytics', compact(
            'statusData',
            'months',
            'monthlyCounts',
            'departmentData',
            'predictionMonths',
            'predictionCounts'
        ));
    }

    public function index(Request $request)
    {
        $agencies = Complaint::distinct()->pluck('agency')->filter()->sort();
        $query = Complaint::query();

        // Tracker Array to capture active filters for descriptive logging
        $activeFilters = [];

        if ($request->filled('search')) {
            $search = $request->search;
            $activeFilters[] = "Search text: '{$search}'";
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date')) {
            $activeFilters[] = "Date: {$request->date}";
            $query->whereDate('created_at', $request->date);
        }

        if ($request->filled('month')) {
            $activeFilters[] = "Month code: {$request->month}";
            $query->whereMonth('created_at', $request->month);
        }

        if ($request->filled('year')) {
            $activeFilters[] = "Year: {$request->year}";
            $query->whereYear('created_at', $request->year);
        }

        if ($request->filled('agency')) {
            $activeFilters[] = "Agency matching: '{$request->agency}'";
            $query->where('agency', 'like', '%'.$request->agency.'%');
        }

        if ($request->filled('status')) {
            $activeFilters[] = "Status: {$request->status}";
            $query->when($request->status, function ($q, $status) {
                $q->where('status', $status);
            });
        }

        $complaints = $query->latest()->paginate(10);
        $agencies = Complaint::distinct()->pluck('agency');
        $data = $this->adminService->getDashboardStats();

        // Compile criteria summary or fallback to general layout view notation
        $filterSummary = count($activeFilters) > 0
            ? 'Criteria applied: '.implode(', ', $activeFilters)
            : 'No active filters applied.';

        // Log Dashboard Indexing Read
        ActivityLog::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'action' => 'View Dashboard Index',
            'description' => "Admin accessed complaint listings index. {$filterSummary}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return view('admin.dashboard', compact('data', 'complaints', 'agencies'));
    }

    public function show(Complaint $complaint)
    {
        $logAction = 'View Complaint';
        $logDescription = "Admin viewed data for complaint ticket record code: {$complaint->code}.";

        // If the admin opens a new complaint, mark it as viewed
        if ($complaint->status === 'pending') {
            $complaint->update(['status' => 'viewed']);

            $logAction = 'Open New Complaint';
            $logDescription = "Admin opened new ticket record code: {$complaint->code} and escalated state from 'pending' to 'viewed'.";
        }

        // Log Item Presentation Event
        ActivityLog::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'action' => $logAction,
            'description' => $logDescription,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return view('admin.show', compact('complaint'));
    }

    public function update(Request $request, Complaint $complaint)
    {
        $request->validate(['admin_response' => 'required|string|min:10']);

        $oldStatus = $complaint->status;
        $this->adminService->updateComplaintStatus($complaint, $request->admin_response);

        // Log Transaction Resolution Changes
        ActivityLog::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'action' => 'Resolve Complaint',
            'description' => "Admin modified ticket record code: {$complaint->code}. Status shifted from '{$oldStatus}' to '{$complaint->status}'.",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Complaint resolved successfully.');
    }
}
