<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Instructor;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class LandingPageController extends Controller
{
    public function index()
    {
        $instructors = Instructor::all();
        $courses = Course::with('instructor')->get();
        // dd($courses);
        $testimonis = Testimoni::all();

        $courses = Course::with('instructor')->get()->map(function ($course) {
            $course->detail_url = URL::signedRoute(
                'show.detail',
                ['id' => $course->id]
            );
            return $course;
        });

        return view('index', compact('courses', 'instructors', 'testimonis'));
    }

    public function about()
    {
        return view('about');
    }

    public function course()
    {
        // gunakan paginate agar bisa pakai ->links()
        $courses = Course::with('instructor')->paginate(6); // 6 item per halaman

        // transform data untuk tambah detail_url
        $courses->getCollection()->transform(function ($course) {
            $course->detail_url = URL::signedRoute(
                'show.detail',
                ['id' => $course->id]
            );
            return $course;
        });

        return view('course', compact('courses'));
    }

    public function show($id)
    {
        $course = Course::with('instructor')->findOrFail($id);

        // transform data untuk tambah detail_url
        $list_course = Course::with('instructor')->get()->map(function ($course) {
            $course->detail_url = URL::signedRoute(
                'show.detail',
                ['id' => $course->id]
            );
            return $course;
        });

        $paginate = Course::with('instructor')->paginate(3);

        return view('detail', compact('course','list_course','paginate'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function team()
    {
        $instructors = Instructor::all();
        return view('instructor',compact('instructors'));
    }

    public function testimonial()
    {
        $testimonis = Testimoni::all();
        return view('testimonial', compact('testimonis'));
    }
}
