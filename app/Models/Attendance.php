<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'students_id',
        'students_has_classes_id',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Relationships
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'students_id');
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(StudentHasClass::class, 'students_has_classes_id');
    }

    // Scopes
    public function scopeForDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }

    public function scopeForClass($query, $classId)
    {
        return $query->whereHas('enrollment', function ($q) use ($classId) {
            $q->where('classes_id', $classId);
        });
    }

    public function scopeForStudent($query, $studentId)
    {
        return $query->where('students_id', $studentId);
    }

    // Accessors
    public function getFormattedDateAttribute()
    {
        return $this->date->format('M d, Y');
    }

    public function getIsRecentAttribute()
    {
        return $this->date->isToday();
    }
}
