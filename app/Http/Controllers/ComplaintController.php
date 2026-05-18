<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Complaint;
use App\Services\ComplaintService;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    protected $complaintService;

    // Inject the Service into the Controller
    public function __construct(ComplaintService $complaintService)
    {
        $this->complaintService = $complaintService;
    }

    /**
     * Display the dashboard with complaints.
     */
    public function index()
    {
        // Fetch paginated complaints for the logged-in user
        $complaints = Complaint::where('user_id', auth()->id())
            ->latest()
            ->paginate(5); // Adjust this number as needed

        return view('dashboard', compact('complaints'));
    }

    /**
     * Store a newly created complaint.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'agency' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'description' => 'required|string',
            'respondent_name' => 'nullable|string|max:255',
            'respondent_position' => 'nullable|string|max:255',
        ]);

        // Ensure your service returns the created model instance
        $complaint = $this->complaintService->createComplaint($validated);

        // Log complaint submission
        ActivityLog::create([
            'user_id' => auth()->id(), // null if an anonymous guest submits
            'user_name' => auth()->check() ? auth()->user()->name : 'Anonymous Stakeholder',
            'action' => 'Grievance Submitted',
            'description' => "New complaint filed regarding '{$validated['title']}' against department '{$validated['department']}'. Generated code: {$complaint->code}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->back()
            ->with('success', 'Your complaint has been submitted.')
            ->with('complaint_code', $complaint->code); // Pass the code to the session for display
    }

    public function track(Request $request)
    {
        // 1. Validate using the correct input name from your HTML (tracking_code)
        $request->validate([
            'tracking_code' => 'required|string',
        ]);

        // 2. Search by the tracking_code input
        $complaint = Complaint::where('code', $request->tracking_code)->first();

        // 3. If not found, return with an error message
        if (! $complaint) {
            // Log tracking lookup failure (useful for monitoring probing or mistyped codes)
            ActivityLog::create([
                'user_id' => auth()->id(),
                'user_name' => auth()->check() ? auth()->user()->name : 'Guest Visitor',
                'action' => 'Tracking Failed',
                'description' => "Attempted to look up non-existent tracking code: '{$request->tracking_code}'",
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return redirect()->back()
                ->withInput() // Keeps the code in the input field
                ->withErrors(['tracking_code' => 'No record found with that tracking code.']);
        }

        // Log successful tracking search
        ActivityLog::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->check() ? auth()->user()->name : 'Guest Visitor',
            'action' => 'Grievance Tracked',
            'description' => "Successfully queried status for complaint record #{$complaint->id} (Code: {$complaint->code}).",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // 4. Return to the same welcome view with the complaint data
        return view('guests.trackrecord', compact('complaint'));
    }

    /**
     * Update the complaint (Admin Resolution).
     */
    public function update(Request $request, Complaint $complaint)
    {
        $request->validate([
            'admin_response' => 'required|string|min:10',
        ]);

        // Use the service to handle the logic for resolving
        $this->complaintService->resolveComplaint(
            $complaint,
            $request->admin_response
        );

        // Log the administrative resolution closure event
        ActivityLog::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'action' => 'Status Update',
            'description' => "Resolved and closed complaint ticket #{$complaint->id} (Code: {$complaint->code}).",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Resolution sent and ticket closed.');
    }
}
