<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Helpers\Helper;
use Carbon\Carbon;
use Defuse\Crypto\Crypto;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
class UserService
{
    public function getUserList($request)
    {
        $searchArray = array();
        parse_str($request->fromValues, $searchArray);
        $query = User::whereHas('role', function ($user) use ($searchArray) {
            // if ($searchArray['role_id'] != '') {
            //     $user->whereId($searchArray['role_id']);
            // }
        })->with('role');
        if ($request->order == null) {
            $query->orderBy('users.id', 'desc');
        }

        /* Get Role Permissions */

        return Datatables::of($query)
            // ->addColumn('role', function ($data) {
            //     if ($data->role->count() > 0) {
            //         return $data->getRoleNames()->implode(',');
            //     }
            //     return '';
            // })
            ->addColumn('action', function ($data) {
                $edit = route('admin.users.edit', [$data]);
                $view = route('admin.users.show', [$data]);
                // $viewLink = $view;
                $deleteLink = $data->id;
                $editLink = $edit;
                return Helper::Action($editLink, $deleteLink, '');
            })


            ->rawColumns(['action'])
            ->make(true);
    }

    public function addEdit($request, $id)
    {
        if ($id != '') {
            $user = User::find($id);
            if ($request->password) {
                $user->password =  Hash::make($request->password);
            }
        } else {
            $user = new User();
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->email_verified_at = now();
        }

        $user->name = $request->name;
        $user->role_id = $request->role_id;
        $user->save();
        
        return $user;
    }

    public function destroy($user)
    {
        $deletedUser = $user->delete();
        return $deletedUser;
    }
}
