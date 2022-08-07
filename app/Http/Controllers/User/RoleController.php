<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(Role::get());
    }
}
