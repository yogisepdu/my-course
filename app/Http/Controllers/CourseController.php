<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\course_content;
use App\Models\course_section;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $title = 'E-Course';
        $description = 'Manage your e-courses here. You can add, edit, and delete courses as needed.';

        $courses = Course::with('instructor')->get();
        return view('admin.course', compact('title', 'description', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $title = 'Create New Course';
        $description = 'Fill in the details to create a new e-course.';

        $instructors = Instructor::with('user')->get();
        
        return view('admin.forms.create_course', compact('title', 'description', 'instructors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'slug' => 'required|string|unique:courses,slug',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'instructor_id' => 'required|exists:instructors,id',
        ]);
        
        // Handle file upload for thumbnail if present
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }
        // Create the course
        Course::create($data);
        
        // Redirect or return response
        return redirect()->route('admin.ecourse.index')->with('success', 'Course created successfully!');
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
        $course = Course::with('instructor')->findOrFail($id);

        // Ambil semua instructor untuk dropdown
        $instructors = Instructor::with('user')->get();

        // Judul + deskripsi halaman (opsional)
        $title = 'Edit Course';
        $description = 'Update the details of the selected course.';

        return view('admin.forms.edit_course', compact('course', 'instructors', 'title', 'description'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $course = Course::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'slug' => 'required|string|unique:courses,slug,' . $course->id,
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'instructor_id' => 'required|exists:instructors,id',
        ]);

        // Handle file upload for thumbnail if present
        if ($request->hasFile('thumbnail')) {
            // Hapus thumbnail lama kalau ada
            if ($course->thumbnail && Storage::disk('public')->exists($course->thumbnail)) {
                Storage::disk('public')->delete($course->thumbnail);
            }

            // Simpan thumbnail baru
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        // Update the course
        $course->update($data);

        return redirect()->route('admin.ecourse.index')->with('success', 'Course updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);

        // Hapus thumbnail dari storage jika ada
        if ($course->thumbnail && Storage::disk('public')->exists($course->thumbnail)) {
            Storage::disk('public')->delete($course->thumbnail);
        }

        // Hapus data course
        $course->delete();

        return redirect()->route('admin.ecourse.index')
            ->with('success', 'Course deleted successfully!');
    }

    public function section(){
        $title = 'Course Section';
        $description = 'Manage your e-courses here. You can add, edit, and delete courses as needed.';

        $section = course_section::with('course')->get();

        return view('admin.course_section', compact('title', 'description', 'section'));
    }

    public function sectionCreate(){
        $title = 'Create New Section';
        $description = 'Fill in the details to create a new section.';

        $courses = Course::with('instructor')->get();
        return view('admin.forms.create_course_section', compact('title', 'description', 'courses'));
    }

    public function sectionStore(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title'     => 'required|string|max:255',
            'order'     => 'required|integer|min:0',
        ]);

        // Simpan data
        course_section::create($validated);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.ecourse.section')
            ->with('success', 'Course section created successfully.');
    }

    public function sectionEdit($id){
        $title = 'Edit Section';
        $description = 'Update the details of the selected section.';

        $section = course_section::findOrFail($id);
        $courses = Course::with('instructor')->get();

        return view('admin.forms.edit_course_section', compact('title', 'description', 'section', 'courses'));
    }

    public function sectionUpdate(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title'     => 'required|string|max:255',
            'order'     => 'required|integer|min:0',
        ]);

        // Simpan data
        course_section::findOrFail($id)->update($validated);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.ecourse.section')
            ->with('success', 'Course section updated successfully.');
    }

    public function sectionDestroy($id){
        course_section::findOrFail($id)->delete();
        return redirect()->route('admin.ecourse.section')->with('success', 'Section deleted successfully!');
    }


    // Course Content
    public function content(){
        $title = 'Course Content';
        $description = 'Manage your e-courses here. You can add, edit, and delete courses as needed.';

        $course = Course::with('instructor')->get();
        $section = course_section::with('course')->get();
        $content = course_content::with('section')->get();

        
        return view('admin.course_content', compact('title', 'description', 'course', 'section', 'content'));
    }

    public function contentCreate(){
        $title = 'Create New Content';
        $description = 'Fill in the details to create a new content.';

        $section = course_section::with('course')->get();
        return view('admin.forms.create_course_content', compact('title', 'description', 'section'));
    }

    public function contentStore(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'section_id'   => 'required|exists:course_sections,id',
            'title'        => 'required|string|max:255',
            'content_type' => 'required|in:video,pdf,text',
            'content_url'  => 'nullable|url',
            'body'         => 'nullable|string',
            'order'        => 'required|integer|min:0',
        ]);

        // Simpan data
        $content = course_content::create($validated);

        // Redirect balik dengan pesan sukses
        return redirect()
            ->route('admin.ecourse.content')
            ->with('success', 'Course content created successfully!');
    }

    public function contentEdit($id){
        $title = 'Edit Content';
        $description = 'Update the details of the selected content.';

        $content = course_content::findOrFail($id);
        $section = course_section::with('course')->get();

        return view('admin.forms.edit_course_content', compact('title', 'description', 'content', 'section'));
    }

    public function contentUpdate(Request $request, $id)
    {
        // Validasi
        $validated = $request->validate([
            'section_id'   => 'required|exists:course_sections,id',
            'title'        => 'required|string|max:255',
            'content_type' => 'required|in:video,pdf,text',
            'content_url'  => 'nullable|url',
            'body'         => 'nullable|string',
            'order'        => 'required|integer|min:0',
        ]);

        // Simpan data
        course_content::findOrFail($id)->update($validated);

        // Redirect balik dengan pesan sukses
        return redirect()
            ->route('admin.ecourse.content')
            ->with('success', 'Course content updated successfully!');
    }

    public function contentDestroy($id){
        course_content::findOrFail($id)->delete();
        return redirect()->route('admin.ecourse.content')->with('success', 'Content deleted successfully!');
    }
}
