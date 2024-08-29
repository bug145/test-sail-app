<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends BaseController
{
    public function index()
    {
        $user = auth()
            ->guard('sanctum')
            ->user();
        $userResource = new UserResource($user);

        return $this->sendResponse($userResource, 'User info');
    }

    public function show(User $user)
    {
        $userResource = new UserResource($user);

        return $this->sendResponse($userResource, 'User info');
    }

    public function update(UserStoreRequest $request)
    {
        $user = auth()
            ->guard('sanctum')
            ->user();

        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');

            if ($file->isValid()) {
                $path = $request->file('avatar')->store("avatars", 'minio');
                $user->update(["avatar" => $path]);
            }
        }

        unset($data['avatar']);
        $user->update($data);

        $userResource = new UserResource($user);

        return $this->sendResponse($userResource, 'User info');
    }

    public function destroy()
    {
        $user = auth()
            ->guard('sanctum')
            ->user();

        $user->delete();


        return $this->sendResponse([], 'User successfully deleted');
    }
}
