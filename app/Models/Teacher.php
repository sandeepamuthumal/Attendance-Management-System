<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',
        'subjects_id',
        'contact_no',
        'address',
        'nic'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subjects_id');
    }
}
