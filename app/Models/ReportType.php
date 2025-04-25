<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReportType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'smallDescription',
    ];

    /**
     * Get the reports for the report type.
     */
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class, 'type_report_id');
    }
}
