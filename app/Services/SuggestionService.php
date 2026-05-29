<?php

namespace App\Services;

use App\Models\Suggestion;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class SuggestionService
{
    // ---------------------------------------------------------------
    // Public (citizen-facing) operations
    // ---------------------------------------------------------------

    /**
     * Persist a new suggestion submitted via the public form.
     *
     * @param  array{
     *     name: string|null,
     *     designation: string|null,
     *     suggestion: string,
     *     category: string|null
     * } $data
     */
    public function store(array $data): Suggestion
    {
        return Suggestion::create([
            'name' => $data['name'] ?? null,
            'designation' => $data['designation'] ?? null,
            'suggestion' => $data['suggestion'],
            'category' => $data['category'] ?? 'other',
            'status' => 'pending',
        ]);
    }

    // ---------------------------------------------------------------
    // Admin operations
    // ---------------------------------------------------------------

    /**
     * Paginated list of suggestions, filterable by status and category.
     */
    public function paginate(
        int $perPage = 20,
        ?string $status = null,
        ?string $category = null,
    ): LengthAwarePaginator {
        $query = Suggestion::query()->latest();

        if ($status) {
            $query->where('status', $status);
        }

        if ($category) {
            $query->where('category', $category);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Update the review status and optional admin notes for a suggestion.
     */
    public function review(Suggestion $suggestion, string $status, ?string $adminNotes = null): Suggestion
    {
        $suggestion->update([
            'status' => $status,
            'admin_notes' => $adminNotes,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        return $suggestion->fresh();
    }

    /**
     * Soft-delete a suggestion (admin only).
     */
    public function delete(Suggestion $suggestion): void
    {
        $suggestion->delete();
    }

    /**
     * Summary counts for the admin dashboard widget.
     *
     * @return array{
     *     total: int,
     *     pending: int,
     *     under_review: int,
     *     acknowledged: int,
     *     implemented: int,
     *     declined: int,
     * }
     */
    public function summaryCounts(): array
    {
        $statuses = ['pending', 'under_review', 'acknowledged', 'implemented', 'declined'];

        $counts = Suggestion::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->all();

        $result = ['total' => array_sum($counts)];

        foreach ($statuses as $s) {
            $result[$s] = $counts[$s] ?? 0;
        }

        return $result;
    }
}
