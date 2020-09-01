<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    protected $fillable=[
        'idServer',
        'instance',
        'task',
        'parameters',
        'process_status',
        'process_log',
    ];

}