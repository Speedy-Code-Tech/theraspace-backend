<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class AdminSchedule extends Model
{
    protected $table = 'schedule';
    public $fillable = ['dates'];
}
