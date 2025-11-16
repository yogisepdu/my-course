<?php

namespace App\Http\Controllers;

use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class TestimoniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $title = 'Testimoni';
        $description = 'Manage your testimoni here. You can add, edit, and delete testimoni as needed.';

        $testimonis = Testimoni::all();
        
        // generate signed url
        $createUrl = URL::signedRoute('admin.testimoni.create');

        // signed url untuk edit tiap testimoni
        $testimonis = Testimoni::all()->map(function ($testimoni) {
            $testimoni->edit_url = URL::signedRoute(
                'admin.testimoni.edit',
                ['id' => $testimoni->id]
            );
            return $testimoni;
        });


        return view('admin.testimoni', compact('title', 'description','testimonis','createUrl'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $title = 'Create Testimoni';
        $description = 'Fill out the form below to create a new testimoni.';

        return view('admin.forms.create_testimoni', compact('title', 'description'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request->all());
        // Validasi input
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'job' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle file upload jika ada
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('testimoni', 'public');
        }

        // Simpan data menggunakan mass assignment
        $testimoni = Testimoni::create([
            'name' => $data['name'],
            'job' => $data['job'],
            'description' => $data['description'],
            'profile_picture' => $data['photo'] ?? null,
        ]);

        return redirect()->route('admin.testimoni.index')->with('success', 'Testimoni created successfully!');
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
        $testimoni = Testimoni::findOrFail($id);

        $title = 'Edit Testimoni';
        $description = 'Update the details of the selected testimoni.';

        return view('admin.forms.edit_testimoni', compact('testimoni', 'title', 'description'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $testimoni = Testimoni::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'job' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle file upload jika ada
        if ($request->hasFile('photo')) {
            // Hapus file lama
            if ($testimoni->profile_picture && Storage::disk('public')->exists($testimoni->profile_picture)) {
                Storage::disk('public')->delete($testimoni->profile_picture);
            }

            // Simpan file baru
            $data['profile_picture'] = $request->file('photo')->store('testimoni', 'public');
        } else {
            // Kalau tidak ada file baru, pakai foto lama
            $data['profile_picture'] = $testimoni->profile_picture;
        }

        // Update data
        $testimoni->update([
            'name' => $data['name'],
            'job' => $data['job'],
            'description' => $data['description'],
            'profile_picture' => $data['profile_picture'],
        ]);

        return redirect()->route('admin.testimoni.index')->with('success', 'Testimoni updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
         $testimoni = Testimoni::findOrFail($id);

        // Hapus file profile_picture di storage kalau ada
        if ($testimoni->profile_picture && Storage::disk('public')->exists($testimoni->profile_picture)) {
            Storage::disk('public')->delete($testimoni->profile_picture);
        }

        // Hapus data dari DB
        $testimoni->delete();

        return redirect()->route('admin.testimoni.index')->with('success', 'Testimoni deleted successfully!');
    }
}
