<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

    static public function fetchUsersFromCache(int $userId)
    {
        return Cache::get($userId);
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(User::with('roles')->get());
    }

    /**
     * @param CreateRequest $createRequest
     * @param User $user
     * @param UserRole $baseUserRole
     * @return JsonResponse
     */
    public function create(
        CreateRequest $createRequest,
        User $user,
        UserRole $baseUserRole
    )
    {
        $user->name = $createRequest->name;
        $user->email = $createRequest->email;
        $user->password = Hash::make($createRequest->password);

        $user->save();

        foreach($createRequest->roles as $roleId) {
            $userRole = clone $baseUserRole;
            $userRole->user_id = $user->id;
            $userRole->role_id = $roleId;

            $userRole->save();
        }

        return response()->json([
            "message" => "Data inserted successfully"
        ], 200);
    }

    public function update(UpdateRequest $updateRequest)
    {
        $user = User::find($updateRequest->id);
        $user->name = $updateRequest->name;
        $user->email = $updateRequest->email;

        $user->save();

        $user->roles()->sync($updateRequest->roles);
    }

    public function delete(int $id)
    {
        $user=User::find($id);
        $user->delete();
    }
}
