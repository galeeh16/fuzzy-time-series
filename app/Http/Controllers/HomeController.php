<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use Validator;
use Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function profile()
    {
        $user = User::where('id', '=', auth()->user()->id)->firstOrFail();
        return view('auth.profile', compact('user'));
    }

    public function changePassword(User $user)
    {
        return view('auth.ganti_password', compact('user'));
    }

    public function updatePassword(Request $request, $id)
    {
        Validator::extend('check_pwd', function ($attribute, $value, $parameters) {
            $user = User::where('id', '=', request()->id)->first();
            if (Hash::check($value, $user->password))
                return true;
            return false;
        }, 'Old password is wrong, please make sure your password is correct');

        Validator::extend('check_pwd_baru', function ($attribute, $value, $parameters) {
            $user = User::where('id', '=', request()->id)->first();
            if (!Hash::check($value, $user->password))
                return true;
            return false;
        }, 'Old password has been used');

        $rules = [
            'old_password' => 'required|check_pwd',
            'new_password' => 'required|check_pwd_baru|max:255',
            'new_password_confirmation' => 'required|same:new_password'
        ];

        // $msg = [
        //     'required' => 'Harap isi :attribute',
        //     'password_baru_confirmation.same' => 'Konfirmasi password dan password baru harus sama'
        // ];

        // $name = [
        //     'old_password' => 'password lama',
        //     'password_baru' => 'password baru',
        //     'password_baru_confirmation' => 'konfirmasi password'
        // ];

        $validator = Validator::make($request->all(), $rules);
        // $validator->setAttributeNames($name);

        if($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        try {
           $user = User::where('id', '=', $id)->first();
           $user->password = Hash::make($request->new_password);
           $user->save(); 
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
        return response(['msg' => 'Success change password', 'status' => 200], 200);
    }
    

}
