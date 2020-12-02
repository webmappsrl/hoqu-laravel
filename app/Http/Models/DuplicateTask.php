<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuplicateTask extends Model
{
    use HasFactory;

    protected $fillable = ['id','id_task'];
    // protected $casts = ['created_at' => 'datetime'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}


