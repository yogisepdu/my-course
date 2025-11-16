<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $title = 'Instructor Management';
        $description = 'Manage your instructors here. You can add, edit, and delete instructors as needed.';

        $instructors = Instructor::with('user')->get();

        return view('admin.instructor', compact('title', 'description', 'instructors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // Ambil semua user dengan role instructor
        $users = User::where('role', 'instructor')
            ->whereNotIn('id', Instructor::pluck('user_id')) // exclude yang sudah jadi instructor
            ->get();

        // dd($users);

        $title = 'Create Instructor';
        $description = 'Fill out the form below to create a new instructor.';
        return view('admin.forms.create_instructor', compact('title', 'description','users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'job' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'youtube' => 'nullable|url',
        ]);

        // Handle file upload jika ada
        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $request->file('profile_picture')->store('instructors', 'public');
        }

        // Simpan data menggunakan mass assignment
        $instructor = Instructor::create([
            'user_id' => $data['user_id'],
            'job' => $data['job'],
            'profile_picture' => $data['profile_picture'] ?? null,
            'links_twitter' => $data['twitter'] ?? null,
            'links_linkedin' => $data['linkedin'] ?? null,
            'links_facebook' => $data['facebook'] ?? null,
            'links_instagram' => $data['instagram'] ?? null,
            'links_youtube' => $data['youtube'] ?? null,
        ]);

        // Redirect dengan flash message
        return redirect()->route('admin.instructor.index')->with('success', 'Instructor created successfully.');
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
        // Ambil data course berdasarkan ID
        $instructor = Instructor::findOrFail($id);

        // Ambil semua instructor untuk dropdown
        $instructors = Instructor::all();

        // Judul + deskripsi halaman (opsional)
        $title = 'Edit instructor';
        $description = 'Update the details of the selected instructor.';

        return view('admin.forms.edit_instructor', compact('instructor', 'instructors', 'title', 'description'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $instructor = Instructor::findOrFail($id);

        // Validasi input
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'job' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'youtube' => 'nullable|url',
        ]);

        // Handle file upload jika ada
        if ($request->hasFile('profile_picture')) {
            // Hapus file lama
            if ($instructor->profile_picture && Storage::disk('public')->exists($instructor->profile_picture)) {
                Storage::disk('public')->delete($instructor->profile_picture);
            }

            // Simpan file baru
            $data['profile_picture'] = $request->file('profile_picture')->store('instructors', 'public');
        } else {
            unset($data['profile_picture']); // biar nggak ke-overwrite null
        }

        // Update data
        $instructor->update([
            'name' => $data['name'],
            'job' => $data['job'],
            'profile_picture' => $data['profile_picture'] ?? $instructor->profile_picture,
            'links_twitter' => $data['twitter'] ?? null,
            'links_linkedin' => $data['linkedin'] ?? null,
            'links_facebook' => $data['facebook'] ?? null,
            'links_instagram' => $data['instagram'] ?? null,
            'links_youtube' => $data['youtube'] ?? null,
        ]);

        return redirect()->route('admin.instructor.index')
            ->with('success', 'Instructor updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $instructor = Instructor::findOrFail($id);

        // Hapus file profile_picture di storage kalau ada
        if ($instructor->profile_picture && Storage::disk('public')->exists($instructor->profile_picture)) {
            Storage::disk('public')->delete($instructor->profile_picture);
        }

        // Hapus data dari DB
        $instructor->delete();

        return redirect()->route('admin.instructor.index')
            ->with('success', 'Instructor deleted successfully.');
    }
}
