<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use Validator;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'username' => 'required|unique:users|max:20',
            'password' => 'required|min:5|max:255',
            'password_confirmation' => 'required|min:5|max:255|same:password',
            'name' => 'required|string|max:255',
            'level' => 'required',
            'phone' => 'sometimes'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        try {
            User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'name' => $request->name,
                'address' => $request->address,
                'level' => $request->level,
                'phone' => $request->phone,
            ]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }

        return response()->json(['msg' => 'Success created user', 'status' => 201], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where('id', '=', $id)->firstOrFail();
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'username' => $request->username == $request->username2 ? 'required' : 'required|unique:users',
            'name' => 'required',
            'address' => 'sometimes',
            'phone' => 'sometimes',
        ];

        $validate = Validator::make($request->all(), $rules);
        if($validate->fails()) {
            return response()->json($validate->messages(), 400);
        }

        try {
            $user = User::where('id', '=', $id)
                        ->update([
                            'username' => $request->username,
                            'name' => $request->name,
                            'address' => $request->address,
                            'phone' => $request->phone,
                        ]);
            if($user) {
                return response()->json(['msg' => 'Berhasil mengubah data', 'status' => 200], 200);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('id', '=', $id)->first();
        try {
            if($user->delete()) {
                return response()->json(['msg' => 'Berhasil menghapus user', 'status' => 200, 'type' => 'success'], 200);
            } else {
                return response()->json(['msg' => 'Gagal menghapus user', 'status' => 200, 'type' => 'error'], 200);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
