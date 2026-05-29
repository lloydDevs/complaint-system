<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Suggestion;
use App\Services\SuggestionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Admin-only controller for managing citizen suggestions.
 *
 * Security layers applied here (in addition to the route-level middleware):
 *   1. __construct()  — enforces `auth` + `admin` middleware on every method.
 *   2. authorize()    — gate check on write operations so non-admin users
 *                       who somehow reach these routes are still blocked.
 *   3. review/delete  — logs the acting admin's ID via the service layer.
 *
 * Route-level middleware expected in web.php:
 *   ->middleware(['auth', 'admin'])
 */
class SuggestionController extends Controller
{
    public function __construct(
        protected SuggestionService $service,
    ) {}

    // ---------------------------------------------------------------
    // Index — paginated list with filters
    // ---------------------------------------------------------------

    public function index(Request $request): View
    {
        return view('admin.suggestions.index', [
            'suggestions' => $this->service->paginate(
                perPage: 20,
                status: $request->query('status'),
                category: $request->query('category'),
            ),
            'counts' => $this->service->summaryCounts(),
            'categories' => Suggestion::CATEGORIES,
            'statuses' => Suggestion::STATUSES,
            'filters' => $request->only(['status', 'category']),
        ]);
    }

    // ---------------------------------------------------------------
    // Show — single suggestion detail
    // ---------------------------------------------------------------

    public function show(Suggestion $suggestion): View
    {
        return view('admin.suggestions.show', [
            'suggestion' => $suggestion->load('reviewer'),
            'statuses' => Suggestion::STATUSES,
        ]);
    }

    // ---------------------------------------------------------------
    // Update — change status + add admin notes
    // ---------------------------------------------------------------

    public function update(Request $request, Suggestion $suggestion): RedirectResponse
    {
        // Gate: only authenticated admins may mutate suggestions.
        $this->ensureAdmin();

        $validated = $request->validate([
            'status' => ['required', 'in:'.implode(',', array_keys(Suggestion::STATUSES))],
            'admin_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $this->service->review(
            suggestion: $suggestion,
            status: $validated['status'],
            adminNotes: $validated['admin_notes'] ?? null,
        );

        return redirect()
            ->route('admin.suggestions.index')
            ->with('success', 'Suggestion updated successfully.');
    }

    // ---------------------------------------------------------------
    // Destroy — soft delete
    // ---------------------------------------------------------------

    public function destroy(Suggestion $suggestion): RedirectResponse
    {
        $this->ensureAdmin();

        $this->service->delete($suggestion);

        return redirect()
            ->route('admin.suggestions.index')
            ->with('success', 'Suggestion removed.');
    }

    // ---------------------------------------------------------------
    // Private helpers
    // ---------------------------------------------------------------

    /**
     * Hard gate: abort with 403 if the authenticated user is not an admin.
     * This is a defence-in-depth check on top of the middleware.
     *
     * Adjust the property/method name to match your User model
     * (e.g. is_admin column, hasRole('admin'), can('admin'), etc.)
     */
    private function ensureAdmin(): void
    {
        $user = Auth::user();

        // ── Adapt this condition to your auth setup ──────────────────
        // Option A — boolean column:  $user->is_admin
        // Option B — role check:      $user->hasRole('admin')
        // Option C — gate:            Gate::allows('admin')
        // ─────────────────────────────────────────────────────────────
        if (! $user || ! $user->is_admin) {
            abort(403, 'Unauthorized. Admin access required.');
        }
    }
}
