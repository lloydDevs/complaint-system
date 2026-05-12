<?php

namespace App\Services;

use App\Models\Complaint;
use Illuminate\Database\Eloquent\Collection;

class AdminComplaintService
{
    public function getDashboardStats(): array
    {
        return [
            'total' => Complaint::count(),
            'pending' => Complaint::where('status', 'pending')->count(),
            'viewed' => Complaint::where('status', 'viewed')->count(), // Added this
            'resolved' => Complaint::where('status', 'resolved')->count(),
            'recent' => Complaint::with('user')->latest()->take(5)->get(),
        ];
    }

    public function getAllComplaints(): Collection
    {
        return Complaint::with('user')->latest()->get();
    }

    public function updateComplaintStatus(Complaint $complaint, string $response): bool
    {
        return $complaint->update([
            'admin_response' => $response,
            'status' => 'resolved',
        ]);
    }
}
