<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminChangePasswordRequest;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateAdminProfileRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Services\RoleService;
use App\Models\User;
use App\Services\UserService;
use Carbon\Carbon;
use Exception;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Helpers\Helper;

class UserController extends Controller
{
    private $userService;
    private $roleService;

    public function __construct(UserService $userService, RoleService $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = $this->roleService->getAllRoles();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->userService->addEdit($request, '');
            session()->flash('success', __('admin.userscreatesuccess'));
            DB::commit();
            return redirect()->route('admin.users.index');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', $e->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = $this->roleService->getAllRoles();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {

            DB::beginTransaction();
            $updatedUser = $this->userService->addEdit($request, $user->id);
            DB::commit();
            if ($updatedUser) {
                session()->flash('success', __('admin.usersupdatesuccess'));
                return redirect()->route('admin.users.index');
            } else {
                session()->flash('error', __('admin.oopserror'));
                return redirect()->route('admin.users.edit');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', $e->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            DB::beginTransaction();
            $deleted = $this->userService->destroy($user);
            DB::commit();
            return Response::json($deleted);
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::json($e->getMessage(), 500);
        }
    }

    public function postUsersList(Request $request)
    {
        return $this->userService->getUserList($request);
    }
}
