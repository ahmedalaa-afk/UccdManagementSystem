<?php

namespace App\Http\Controllers\Admin;

use App\Exports\StudentExport;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\RetriveStudentsResource;
use App\Imports\StudentImport;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function import(Request $request)
    {
        if ($request->hasFile('file')) {
            $request->validate([
                'file' => 'required|file|mimes:xlsx'
            ]);
            $file = $request->file('file');
            Excel::import(new StudentImport, $file);
            return ApiResponse::sendResponse('Students imported successfully.', [], true);
        }
        return ApiResponse::sendResponse('somthing went wrong with file pleas try again.', [], false);
    }

    public function export()
    {
        return Excel::download(new StudentExport, 'students.xlsx');
    }

    public function getAllStudents()
    {
        $students = User::whereHas('roles', function ($q) {
            $q->where('name', 'student');
        })->get();
        return ApiResponse::sendResponse('Students retrieved successfully.', RetriveStudentsResource::collection($students), true);
    }
}
