<?php

namespace App\Services;
use App\Models\Role;

class RoleService
{
    public function getAllRoles()
    {
        return Role::all();
    }
}
