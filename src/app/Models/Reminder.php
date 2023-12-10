<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
      'title',
      'description',
      'remind_at',
      'event_at'
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($reminder){
            $reminder->user_id = Auth::user()->id;
        });
    }
}
