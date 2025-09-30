<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'subject_code'
    ];

    public $timestamps = false;

    public function teachers()
    {
        return $this->hasMany(Teacher::class, 'subjects_id');
    }
}
