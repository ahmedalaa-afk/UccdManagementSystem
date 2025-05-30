<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    protected $table = 'courses';
    protected $guarded = [];

    public function manager()
    {
        return $this->belongsTo(User::class)->whereHas('roles', function ($q) {
            $q->where('name', 'admin');
        });
    }
    public function instructor()
    {
        return $this->hasOne(User::class)->whereHas('roles', function ($q) {
            $q->where('name', 'instructor');
        });
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_user')->withPivot('status')->withTimestamps();
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function attendances()
    {
        return $this->belongsToMany(User::class, 'attendances')
            ->withPivot('status', 'created_at')
            ->withTimestamps();
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function rateings()
    {
        return $this->hasMany(CourseRateing::class);
    }
}
