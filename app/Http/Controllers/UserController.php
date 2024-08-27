<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends BaseController
{
    public function index()
    {
        $user = auth()
            ->guard('sanctum')
            ->user()
            ->withCount('posts')
            ->withCount('comments')
            ->get();

        return $this->sendResponse($user, 'User info');
    }

    public function show(User $user)
    {
        $user = $user
            ->withCount('posts')
            ->withCount('comments')
            ->get()
            ->first()
            ->makeHidden(['email_verified_at', 'updated_at', 'email']);

        return $this->sendResponse($user, 'User info');
    }

    public function update(UserStoreRequest $request)
    {
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');

            // $request->file('avatar')->store("public/avatars/" . $file->getClientOriginalName(), 'minio');
            Storage::disk('minio')->put($file->getClientOriginalName(), $file);
        }

        $data = $request->validated();
        // $user = auth()
        //     ->guard('sanctum')
        //     ->user();

        return $this->sendResponse($data, 'User info');
    }
}
