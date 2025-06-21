<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentHasClass extends Model
{
    use HasFactory;

    protected $table = 'students_has_classes';

    protected $fillable = [
        'students_id',
        'classes_id',
        'enrolled_date',
        'status'
    ];

    protected $casts = [
        'enrolled_date' => 'date',
        'status' => 'boolean'
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class, 'students_id');
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'classes_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeForStudent($query, $studentId)
    {
        return $query->where('students_id', $studentId);
    }

    public function scopeForClass($query, $classId)
    {
        return $query->where('classes_id', $classId);
    }
}
