<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseRateing extends Model
{
    protected $table = 'course_rateings';
    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getRatingAverage()
    {
        return $this->course->rateings()->avg('rating');
    }
}
