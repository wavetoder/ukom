<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        return view('user.user_index', compact('users', 'roles')); 
    }

    public function create()
    {
        $roles = Role::all();
        return view ('user.user_create', compact('roles'));
    }
    public function hapus($id)
    {
        user::find($id)->delete();
        return redirect('/user');
    
    }

    public function store(Request $request)
    {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8',
        'roles' => 'required|array',
    ]);

    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = bcrypt($request->password);
    $user->save();

    $user->assignRole($request->roles);

    return redirect()->route('users.index')->with('succes', 'user berhasil ditambahkan');
    }


}