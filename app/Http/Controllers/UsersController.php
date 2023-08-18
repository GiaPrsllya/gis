<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {
        $titikrawan = User::all();
        $data = [
            'users' => $titikrawan
        ];

        return view('kelola/users', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        $data = [
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'])
        ];

        User::create($data);

        session()->flash('success', 'Users berhasil ditambahkan');
        return redirect('/users');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        if ($request['password'] != null) {
            $data = [
                'name' => $request['name'],
                'password' => Hash::make($request['password'])
            ];
        } else {
            $data = [
                'name' => $request['name']
            ];
        }


        User::find($id)->update($data);

        session()->flash('success', 'Users berhasil diubah');
        return redirect('/users');
    }

    public function destroy($id)
    {
        User::find($id)->delete();

        session()->flash('success', 'Users berhasil dihapus');
        return redirect('/users');
    }
}
