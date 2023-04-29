<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Traits\Common;

class AuthService
{
    use Common;

    public function authenticate($request)
    {
        try {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                $roles = $user->roles[0];
                if ($roles->name == 'user') {
                    Auth::logout();
                    return back()->withInput()->withError(__('admin.notAuthorizedAdmin'));
                }
                if ($user->status == config('const.statusInActiveInt')) {
                    Auth::logout();
                    return back()->withInput()->withError(__('admin.accountInactive'));
                }

                $request->session()->regenerate();
                return redirect()->route('admin.dashboard');
                User::where('id', auth()->user()->id)->update(["timezone" => $request->timezone]);
            }
            return back()->withInput()->withError(__('admin.AuthenticationFail'));
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return back()->withInput();
        }
    }

    /* Logout */
    public function logout($request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('admin.login.show'));
    }

    public function register($request)
    {
        // dd(config('const.ADMIN_ROLE'));
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => config('const.ADMIN_ROLE')
        ]);
    }

    public function bloggerRegister($request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => config('const.BLOGGER_ROLE')
        ]);
    }
}
