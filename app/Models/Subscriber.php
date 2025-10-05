<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Support\Str;

class Subscriber extends Model
{
     protected $table = 'subscribers';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [
       'id'
    ];

      protected static function booted()
    {
        static::creating(function ($user) {
            if (!$user->id) {
                $user->id = (string) Str::uuid();
            }
        });
    }
}
