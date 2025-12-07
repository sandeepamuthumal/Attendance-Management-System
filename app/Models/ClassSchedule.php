<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'classes_id',
        'date',
        'start_time',
        'end_time',
        'location',
        'recurring_pattern',
    ];


    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'classes_id');
    }

}
