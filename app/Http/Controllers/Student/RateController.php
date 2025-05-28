<?php

namespace App\Http\Controllers\Student;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRateRequest;
use App\Models\Course;
use App\Models\CourseRateing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RateController extends Controller
{
    public function store(StoreRateRequest $request)
    {
        $course = Course::where('slug', $request->course_slug)->firstOrFail();
        $user = Auth::user();

        // check if user not enrolled in the course
        if (!$course->students->contains($user->id)) {
            return ApiResponse::sendResponse('You are not enrolled in this course', [], false);
        }

        // check if user is accepted in the course
        $userStatus = $course->students()->where('user_id', $user->id)->first()->pivot->status;
        if ($userStatus !== 'accepted') {
            return ApiResponse::sendResponse('You are not accepted in this course', [], false);
        }

        // check if today is the last day of the course
        $today = now()->startOfDay();
        $courseEndDate = \Carbon\Carbon::parse($course->course_end)->startOfDay();

        if ($today->ne($courseEndDate)) {
            return ApiResponse::sendResponse('You can only rate the course on the last day', [], false);
        }

        // check if user already rated the course
        $rating = CourseRateing::where('course_id', $course->id)->where('user_id', $user->id)->first();
        if ($rating) {
            return ApiResponse::sendResponse('You already rated this course', [], false);
        }

        // create new rating
        $rating = new CourseRateing();
        $rating->course_id = $course->id;
        $rating->user_id = $user->id;
        $rating->rating = $request->rating;
        $rating->review = $request->review;
        $rating->save();

        return ApiResponse::sendResponse('Rating submitted successfully', [], true);
    }
}
