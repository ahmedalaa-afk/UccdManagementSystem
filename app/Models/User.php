<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table = 'users';
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // All Users Section
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function likedPosts()
    {
        return $this->hasMany(Like::class)->where('likeable_type', Post::class);
    }

    public function interests()
    {
        return $this->belongsToMany(Category::class, 'interests')->withTimestamps();
    }

    // User Section
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_user')->withPivot('status')->withTimestamps();
    }


    public function attendances()
    {
        return $this->belongsToMany(Course::class, 'attendances')
            ->withPivot('status', 'created_at')
            ->withTimestamps();
    }

    // Instructor Section
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id')
            ->whereHas('roles', function ($q) {
                $q->where('name', 'admin');
            });
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    // Admin Section
    public function instructors()
    {
        return $this->hasMany(User::class, 'manager_id')->whereHas('roles', function ($q) {
            $q->where('name', 'instructor');
        });
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function rateings()
    {
        return $this->hasMany(CourseRateing::class);
    }
}
