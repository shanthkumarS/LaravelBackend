<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;

class UserRolesController extends Controller
{
    /**
     * @param int $userId
     * @return array
     */
    public function index(int $userId): array
    {
        $roleObjects = $this->fetchUserRoles($userId);

        $roles = [];
        foreach ($roleObjects as $roleObject) {
            $roles[] = $roleObject->name;
        }

        return $roles;
    }

    /**
     * @param int $userId
     * @return Role[]
     */
    private function fetchUserRoles(int $userId)
    {
        return User::find($userId)->roles;
    }
}
