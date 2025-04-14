<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /** @use HasFactory<\Database\Factories\ReportFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'report_type_id',
        'reportable_id',
        'reportable_type',
        'description',
        'status',

    ];


    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function reportable()
    {
        return $this->morphTo();
    }

    public function reportType()
    {
        return $this->belongsTo(ReportType::class);
    }

    // public function scopePending($query)
    // {
    //     return $query->where('status', 'pending');
    // }

    // public function scopeApproved($query)
    // {
    //     return $query->where('status', 'approved');
    // }


    // public function scopeRejected($query)
    // {
    //     return $query->where('status', 'rejected');
    // }


}
