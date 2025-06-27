<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;
    protected $table = 'classes';

    protected $fillable = [
        'class_name',
        'subjects_id',
        'teachers_id',
        'year',
        'grades_id',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
        'year' => 'integer'
    ];

    // Relationships
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subjects_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teachers_id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grades_id');
    }

    public function enrollments()
    {
        return $this->hasMany(StudentHasClass::class, 'classes_id');
    }

    // Accessors
    public function getFullClassNameAttribute()
    {
        return $this->class_name . ' - ' . $this->subject->subject . ' (' . $this->year . ')';
    }

    public function getStatusTextAttribute()
    {
        return $this->status ? 'Active' : 'Inactive';
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 0);
    }

    public function scopeByYear($query, $year)
    {
        return $query->where('year', $year);
    }

    public function scopeByGrade($query, $gradeId)
    {
        return $query->where('grades_id', $gradeId);
    }

    public function scopeBySubject($query, $subjectId)
    {
        return $query->where('subjects_id', $subjectId);
    }

    public function scopeByTeacher($query, $teacherId)
    {
        return $query->where('teachers_id', $teacherId);
    }

    public function scopeWithRelations($query)
    {
        return $query->with(['subject', 'teacher.user', 'grade']);
    }
}
