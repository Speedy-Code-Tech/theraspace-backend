<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theraphist extends Model
{
    protected $table = 'therapists';

    protected $fillable = [
        'first_name',
        'last_name',
        'specialization',
        'email',
        'phone_number',
    ];

   
}
