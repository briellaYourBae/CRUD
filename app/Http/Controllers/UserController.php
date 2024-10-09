<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $users = User::all(); // Pastikan menggunakan () untuk memanggil method

        return view('users.index', compact("users"));
    }

    public function create(){
        return view('users.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|min:3|max:8'
        ]);

        $password = Hash::make($request->password);

        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => $password
        ]);
        return redirect()->route('users.index')
                         ->with('success', 'User berhasil ditambahkan');
    }

    public function show(User $user){
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required'
        ]);

        $user->update($request->all());

        return redirect()->route('users.index')
                         ->with('success', 'User berhasil diupdate');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
                         ->with('success', 'User berhasil dihapus');
    }
}
