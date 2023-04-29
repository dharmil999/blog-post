<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Services\AuthService;
use Illuminate\Support\Facades\DB;
use Exception;


class AuthController extends Controller
{
    public $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function index()
    {
        return view('admin.auth.login');
    }

    public function login(LoginRequest $request)
    {
        try {
            return $this->authService->authenticate($request);
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return back()->withInput();
        }
    }

    public function logout(Request $request)
    {
        try {
            return $this->authService->logout($request);
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return back()->withInput();
        }
    }

    public function registerview()
    {
        return view('admin.auth.register');
    }

    public function bloggerRegisterview()
    {
        return view('admin.auth.bloggerregister');
    }

    public function registerPost(Request $request)
    {
        try {
            $this->authService->register($request);
            return redirect(route('admin.login.show'))->with('success',__('admin.registersuccess'));
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
            return back()->withInput();
        }
    }

    public function bloggerRegisterPost(Request $request)
    {
        try {
            $this->authService->bloggerRegister($request);
            return redirect(route('admin.login.show'))->with('success',__('admin.registersuccess'));
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
            return back()->withInput();
        }

        
    }
}
