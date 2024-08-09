<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'tasks';

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'assign_by',
        'user_id',
        'status',
        'task_start',
        'task_complete',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
