<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        return view('admin.user.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|max:45',
                'email' => 'required',
                'role' => 'required|in:admin,petugas,peminjam',
            ]
        );

        $user = User::create(
            [
            'name'=> $request->name,
            'email'=> $request->email,
            'role' => $request->role,
            'password'=> bcrypt($request->password),
            ]
        );

            return redirect()->route('user.index')->with('success','Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'name' => 'required|max:45',
                'email' => 'required',
            ]
        );

        $user = User::find($id);
        $user->update([

            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

            return redirect()->route('user.index')->with('success', 'Data Berhasil di edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
     $user = User::find($id);
        $user->delete();

    return redirect()->route('user.index')->with('success', 'Data Berhasil di hapus');
    }
}
