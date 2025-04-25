<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'reportable_id',
        'reportable_type',
        'utilisateur_id',
        'date',
        'raison',
        'type_report_id',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    /**
     * Get the reportable model.
     */
    public function reportable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the user that owns the report.
     */
    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    /**
     * Get the report type that owns the report.
     */
    public function type_report(): BelongsTo
    {
        return $this->belongsTo(ReportType::class, 'type_report_id');
    }
}
