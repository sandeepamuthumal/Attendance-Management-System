<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_types_id',
        'first_name',
        'last_name',
        'email',
        'password',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function userType()
    {
        return $this->belongsTo(UserType::class, 'user_types_id');
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class, 'users_id');
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function isAdmin()
    {
        return $this->userType->user_type === 'Admin';
    }

    public function isTeacher()
    {
        return $this->userType->user_type === 'Teacher';
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeByUserType($query, $userTypeId)
    {
        return $query->where('user_types_id', $userTypeId);
    }

    public function status()
    {
        return $this->status === 1 ? 'active' : 'inactive';
    }

    public function userTypeName()
    {
        return $this->userType ? $this->userType->user_type : 'Unknown';
    }
}
