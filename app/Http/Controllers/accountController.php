<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class accountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $title = 'Account';
        $description = 'Manage your account here. You can update your profile, change your password, and more.';
        $users = User::all();
        // generate signed url
        $createUrl = URL::signedRoute('admin.account.create');

        // signed url untuk edit tiap user
        $users = User::all()->map(function ($user) {
            $user->edit_url = URL::signedRoute(
                'admin.account.edit',
                ['id' => $user->id]
            );
            return $user;
        });
        return view('admin.account', compact('title', 'description', 'createUrl', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $title = 'Create Account';
        $description = 'Fill out the form below to create a new account.';

        return view('admin.forms.create_account', compact('title', 'description'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
         // 1. Validasi input
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed', 
            'role'     => 'required|in:student,instructor,admin',
        ]);

        // 2. Simpan user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        // 3. Redirect atau response
        return redirect()->route('admin.account.index')
            ->with('success', 'User berhasil ditambahkan!');
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
        //
        $user= User::findOrFail($id);

        $title = 'Edit Account';
        $description = 'Update the details of the selected account.';

        return view('admin.forms.edit_account', compact('user', 'title', 'description'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role'     => 'required|in:student,instructor,admin',
        ]);

        $user->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role,
        ]);

        return redirect()->route('admin.account.index')
            ->with('success', 'User berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.account.index')
            ->with('success', 'User berhasil dihapus!');
    }
}
