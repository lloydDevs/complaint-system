<?php

namespace App\Services;

use App\Models\Complaint;

class AnalyticsService
{
    /**
     * Get the distribution of complaints by status.
     */
    public function getStatusDistribution(): array
    {
        return [
            Complaint::where('status', 'pending')->count(),
            Complaint::where('status', 'viewed')->count(),
            Complaint::where('status', 'resolved')->count(),
        ];
    }

    /**
     * Get monthly influx trends for the last X months.
     */
    public function getMonthlyTrends(int $limit = 6): array
    {
        $months = collect();
        $counts = collect();

        for ($i = $limit - 1; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months->push($date->format('M'));

            $counts->push(
                Complaint::whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->count()
            );
        }

        return [
            'labels' => $months,
            'data' => $counts,
        ];
    }
}
