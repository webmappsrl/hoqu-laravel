<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Task extends Model
{
    use HasFactory;

        protected $fillable = ['id','id_server','instance','job','parameters','process_status','process_log'];

        protected $casts = [
	'created_at' => 'datetime',
	'updated_at' => 'datetime'
];

}