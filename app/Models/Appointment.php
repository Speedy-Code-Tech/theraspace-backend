<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_date',
        'appointment_time',
        'status',
        'user_id',
        'notes',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime', // Ensures proper formatting
    ];

    /**
     * Relationship: An appointment belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
