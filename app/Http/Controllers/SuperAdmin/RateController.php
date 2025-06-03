<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\RateResource;
use App\Models\Course;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function getCourseRate(Request $request)
    {
        $request->validate([
            'course_slug' => 'required|exists:courses,slug',
        ]);

        $course = Course::where('slug', $request->course_slug)->first();

        if (!$course) {
            return ApiResponse::sendResponse('Course not found', [], false);
        }

        return ApiResponse::sendResponse('Course rates fetched successfully', RateResource::collection($course->rateings), true);
    }
}
