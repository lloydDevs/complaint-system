<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'title', 'description', 'admin_response', 'status'])]
class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'description',
        'admin_response',
        'agency',
        'department',
        'respondent_name',
        'respondent_position',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
