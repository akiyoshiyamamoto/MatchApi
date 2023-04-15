<?php

namespace App\Http\Controllers;

use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Http\Requests\UploadProfileImageRequest;
use Database\migrations\ProfileImageService;

class ProfileImageController extends Controller
{
    private ProfileImageService $profileImageService;
    private UserRepositoryInterface $userRepository;

    public function __construct(ProfileImageService $profileImageService, UserRepositoryInterface $userRepository)
    {
        $this->profileImageService = $profileImageService;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $userId = auth()->id();
        $profileImages = $this->userRepository->getProfileImages($userId);

        return response()->json(['profile_images' => $profileImages]);
    }

    public function upload(UploadProfileImageRequest $request)
    {
        $user = $this->userRepository->getUserById(auth()->user()->id);
        $path = $this->profileImageService->upload($request->file('image'));
        $this->userRepository->addProfileImage($user->getId(), $path);

        return response()->json(['message' => '画像がアップロードされました。', 'path' => $path]);
    }

    public function delete($imageId)
    {
        $user = $this->userRepository->getUserById(auth()->user()->id);
        $imagePath = $this->userRepository->getProfileImagePathById($imageId);
        $this->profileImageService->delete($imagePath);
        $this->userRepository->removeProfileImage($imageId);

        return response()->json(['message' => '画像が削除されました。']);
    }
}
