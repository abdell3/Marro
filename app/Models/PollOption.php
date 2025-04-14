<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PollOption extends Model
{
    /** @use HasFactory<\Database\Factories\PollOptionFactory> */
    use HasFactory;


    protected $fillable = [
        'poll_id',
        'text',
        'votes',
    ];


    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }



    public function voters()
    {
        return $this->belongsToMany(User::class, 'poll_option_user');
    }



}
