<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade',
    ];

    public function classes()
    {
        return $this->hasMany(ClassModel::class, 'grades_id');
    }
}
