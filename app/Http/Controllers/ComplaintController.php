<?php

namespace App\Http\Controllers;

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

        // Hand off the data to the service
        $this->complaintService->createComplaint($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Your complaint has been submitted to the designated agency.');
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

        return redirect()->route('admin.dashboard')
            ->with('success', 'Resolution sent and ticket closed.');
    }
}
