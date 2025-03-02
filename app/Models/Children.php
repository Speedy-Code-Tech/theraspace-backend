<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Children extends Model
{
    protected $table = 'childrens';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'age',
        'therapy_needs',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    } 
}
