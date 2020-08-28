<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    protected $fillable=[
        'instance',
        'task',
        'parameters',
        'process_status',
        'process_log',
    ];

}