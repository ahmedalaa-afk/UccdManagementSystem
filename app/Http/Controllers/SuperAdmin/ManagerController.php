<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Helpers\ApiResponse;
use App\Helpers\Slug;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreManagerRequest;
use App\Http\Requests\UpdateManagerRequest;
use App\Http\Resources\ManagerResource;
use App\Models\User;
use App\Service\FileUploadService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class ManagerController extends Controller
{

    protected $fileUploadService;
    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function store(StoreManagerRequest $request)
    {
        // Handle image
        $image = $request->file('image');
        $path = $this->fileUploadService->uploadImage($image);

        $username = Slug::makeUser(new User(), $request->name);

        $manager = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'username' => $username,
            'password'    => bcrypt($request->password),
            'phone'       => $request->phone,
            'description' => $request->description,
            'image'       => $path,
            'address'     => $request->address,
            'birth_date'   => $request->birthdate,
            'gender'      => $request->gender,
        ]);

        $manager->assignRole('manager');

        return ApiResponse::sendResponse('Manager created successfully', new ManagerResource($manager), true);
    }

    public function update(UpdateManagerRequest $request)
    {
        if ($request->has('email')) {
            $manager = User::where('email', $request->email)->first();
            if (!$manager) {
                $manager = User::where('username', $request->username)->first();
            }
        }

        // Handle file upload if a file is provided

        $manager->update([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => bcrypt($request->password),
            'phone'       => $request->phone,
            'description' => $request->description,
            'address'     => $request->address,
            'birth_date'   => $request->birthdate,
            'gender'      => $request->gender,
        ]);

        if ($request->hasFile('image')) {
            // delete previous image
            $this->fileUploadService->deleteImage($manager->image);
            $manager->image = null;
            $manager->save();

            // Handle file upload if a file is provided
            $image = $request->file('image');
            $path = $this->fileUploadService->uploadImage($image);
            $manager->image = $path;
            $manager->save();
        }

        return ApiResponse::sendResponse('Manager updated successfully', new ManagerResource($manager), true);
    }

    public function show(Request $request)
    {
        $input = $request->username;
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            $manager = User::where('email', $input)->first();
        } else {
            $manager = User::where('username', $input)->first();
        }

        if ($manager) {
            return ApiResponse::sendResponse('manager created successfully', new ManagerResource($manager), true);
        } else {
            return ApiResponse::sendResponse('manager not found', [], false);
        }
    }

    public function delete(Request $request)
    {
        $input = $request->username;
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            $manager = User::where('email', $input)->first();
        } else {
            $manager = User::where('username', $input)->first();
        }
        if ($manager) {
            $manager->delete();
            return ApiResponse::sendResponse('manager deleted successfully', [], true);
        } else {
            return ApiResponse::sendResponse('manager not found', [], false);
        }
    }

    public function restore(Request $request)
    {
        $input = $request->username;
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            $manager = User::onlyTrashed('email', $input)->first();
        } else {
            $manager = User::onlyTrashed('username', $input)->first();
        }
        if ($manager) {
            $manager->restore();
            return ApiResponse::sendResponse('manager retored successfully', [], true);
        } else {
            return ApiResponse::sendResponse('manager not found', [], false);
        }
    }
}
