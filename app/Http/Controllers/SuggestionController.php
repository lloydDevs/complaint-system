<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSuggestionRequest;
use App\Models\Suggestion;
use App\Services\SuggestionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuggestionController extends Controller
{
    public function __construct(
        protected SuggestionService $service,
    ) {}

    public function index(Request $request): View
    {
        return view('suggestions.index', [
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

    /**
     * Display the public suggestion form embedded in the landing page.
     * (Optional — the form can also live inline on the welcome blade.)
     */
    public function create(): View
    {
        return view('suggestions.create', [
            'categories' => Suggestion::CATEGORIES,
        ]);
    }

    /**
     * Validate and persist the public suggestion submission.
     */
    public function store(StoreSuggestionRequest $request): RedirectResponse
    {
        $this->service->store($request->validated());

        return redirect()
            ->route('landing', ['#suggestions'])
            ->with('success', 'Thank you! Your suggestion has been received. We appreciate your feedback.');
    }
}
