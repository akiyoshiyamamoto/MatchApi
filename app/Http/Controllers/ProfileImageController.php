<?php

namespace App\Http\Controllers;

use App\Domain\ProfileImage\Services\ProfileImageService;
use App\Domain\User\Services\UserService;
use App\Http\Requests\UploadProfileImageRequest;

class ProfileImageController extends Controller
{
    private ProfileImageService $profileImageService;

    private UserService $userService;

    public function __construct(ProfileImageService $profileImageService, UserService $userService)
    {
        $this->profileImageService = $profileImageService;
        $this->userService = $userService;
    }

    public function index()
    {
        $userId = auth()->id();
        $profileImages = $this->userService->getProfileImages($userId);

        return response()->json(['profile_images' => $profileImages]);
    }

    public function upload(UploadProfileImageRequest $request)
    {
        $user = $this->userService->findUserById(auth()->user()->id);
        $path = $this->profileImageService->upload($request->file('image'));
        $this->userService->addProfileImage($user->getId(), $path);
        return response()->json(['message' => '画像がアップロードされました。', 'path' => $path]);
    }

    public function delete(int $profileImageId)
    {
        $imagePath = $this->userService->getProfileImagePathById($profileImageId);
        $this->profileImageService->delete($imagePath);
        $this->userService->removeProfileImage($profileImageId);

        return response()->json(['message' => '画像が削除されました。']);
    }
}
