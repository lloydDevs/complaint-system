<?php

namespace App\Services;

use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ComplaintService
{
    public function createComplaint(array $data)
    {
        return Complaint::create([
            'user_id' => Auth::id(),
            'code' => 'PH-'.strtoupper(Str::random(8)), // Generates unique tracking code
            'title' => $data['title'],
            'agency' => $data['agency'],
            'department' => $data['department'],
            'description' => $data['description'],
            'respondent_name' => $data['respondent_name'] ?? null,
            'respondent_position' => $data['respondent_position'] ?? null,
            'status' => 'pending',
        ]);
    }

    public function resolveComplaint(Complaint $complaint, string $response)
    {
        return $complaint->update([
            'admin_response' => $response,
            'status' => 'resolved',
        ]);
    }
}
