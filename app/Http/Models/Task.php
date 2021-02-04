<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Task extends Model
{
    use HasFactory;


        protected $fillable = ['id','id_server','instance','job','parameters','process_status','process_log','ip_server','error_log'];

        protected $casts = [
	'created_at' => 'datetime:Y-m-d',
	'updated_at' => 'datetime'
    ];

    public function duplicateTask()
    {
        return $this->hasMany(duplicateTask::class);
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->format('Y-m-d');
    }
}
