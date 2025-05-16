<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use SoftDeletes;

    protected $table = 'assignments';
    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function instructor()
    {
        return $this->belongsTo(User::class)->whereHas('roles', function ($q) {
            $q->where('name', 'instructor');
        });
    }
    public function files()
    {
        return $this->hasMany(AssignmentFiles::class);
    }
}
