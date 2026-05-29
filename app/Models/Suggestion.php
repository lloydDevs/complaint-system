<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suggestion extends Model
{
    use HasFactory, SoftDeletes;

    // ---------------------------------------------------------------
    // Mass-assignable attributes
    // ---------------------------------------------------------------
    protected $fillable = [
        'name',
        'designation',
        'suggestion',
        'category',
        'status',
        'admin_notes',
        'reviewed_by',
        'reviewed_at',
    ];

    // ---------------------------------------------------------------
    // Casts
    // ---------------------------------------------------------------
    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    // ---------------------------------------------------------------
    // Category labels (used in views / exports)
    // ---------------------------------------------------------------
    public const CATEGORIES = [
        'service_improvement' => 'Service Improvement',
        'policy' => 'Policy',
        'staff_behavior' => 'Staff Behavior',
        'facilities' => 'Facilities',
        'processes' => 'Processes',
        'other' => 'Other',
    ];

    // ---------------------------------------------------------------
    // Status labels
    // ---------------------------------------------------------------
    public const STATUSES = [
        'pending' => 'Pending',
        'under_review' => 'Under Review',
        'acknowledged' => 'Acknowledged',
        'implemented' => 'Implemented',
        'declined' => 'Declined',
    ];

    // ---------------------------------------------------------------
    // Relationships
    // ---------------------------------------------------------------

    /**
     * Admin user who reviewed this suggestion.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // ---------------------------------------------------------------
    // Accessors
    // ---------------------------------------------------------------

    /**
     * Return a human-readable submitter label.
     * Falls back to "Anonymous" when neither name nor designation is set.
     */
    public function getSubmitterLabelAttribute(): string
    {
        if ($this->name && $this->designation) {
            return "{$this->name} — {$this->designation}";
        }

        return $this->name ?? 'Anonymous';
    }

    /**
     * Human-readable category label.
     */
    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? ucfirst($this->category);
    }

    /**
     * Human-readable status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }

    // ---------------------------------------------------------------
    // Scopes
    // ---------------------------------------------------------------

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }
}
