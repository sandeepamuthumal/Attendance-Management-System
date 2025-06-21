<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

     protected $fillable = [
        'student_id',
        'first_name',
        'last_name',
        'contact_no',
        'parent_contact_no',
        'email',
        'nic',
        'address',
        'status'
    ];

    protected $casts = [
        'enrolled_date' => 'date'
    ];

    // Relationships
    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'students_has_classes', 'students_id', 'classes_id')
                    ->withPivot(['enrolled_date', 'status'])
                    ->withTimestamps()
                    ->wherePivot('status', 1);
    }

    public function allClasses()
    {
        return $this->belongsToMany(ClassModel::class, 'students_has_classes', 'students_id', 'classes_id')
                    ->withPivot(['enrolled_date', 'status'])
                    ->withTimestamps();
    }

    public function studentClasses()
    {
        return $this->hasMany(StudentHasClass::class, 'students_id');
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getStatusTextAttribute()
    {
        return $this->status ? 'Active' : 'Inactive';
    }

    public function getQrCodeDataAttribute()
    {
        return [
            'student_id' => $this->student_id,
            'name' => $this->full_name,
            'email' => $this->email,
            'generated_at' => now()->toISOString()
        ];
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

    public function scopeByStudentId($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('student_id', 'like', "%{$search}%")
              ->orWhere('first_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('nic', 'like', "%{$search}%");
        });
    }

    // Generate unique student ID
    public static function generateStudentId(): string
    {
        $year = date('Y');
        $prefix = 'STU' . $year;

        // Get the last student ID for this year
        $lastStudent = self::where('student_id', 'like', $prefix . '%')
                          ->orderBy('student_id', 'desc')
                          ->first();

        if ($lastStudent) {
            $lastNumber = (int) substr($lastStudent->student_id, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    // Boot method to auto-generate student_id
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($student) {
            if (empty($student->student_id)) {
                $student->student_id = self::generateStudentId();
            }
        });
    }
}
