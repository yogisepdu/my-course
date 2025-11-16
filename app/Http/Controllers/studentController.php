<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\course_content;
use App\Models\course_progress;
use App\Models\Instructor;
use App\Models\Testimoni;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class studentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        
        return view('student.index', compact('courses', 'instructors', 'testimonis'));
    }

    public function show()
    {
        //
        $instructors = Instructor::all();
        $courses = Course::with('instructor')->get();
        // dd($courses);
        $testimonis = Testimoni::all();

        $courses = Course::with('instructor')
            ->paginate(10) // jumlah per halaman
            ->through(function ($course) {
                $course->detail_url = URL::signedRoute(
                    'student.detail',
                    ['id' => $course->id]
                );
                return $course;
            });

        
        return view('student.my-course', compact('courses', 'instructors', 'testimonis'));
    }

    public function detail($id)
    {
        $userId = auth()->id();

        $course = Course::with([
            'instructor.user',
            'sections' => function ($q) {
                $q->orderBy('order'); // urutkan section
            },
            'sections.contents' => function ($q) {
                $q->orderBy('order'); // urutkan content di tiap section
            }
        ])->findOrFail($id); // 🚀 hapus orderBy('order') di sini

        $totalContents = $course->sections->sum(fn($section) => $section->contents->count());

        $completedIds = course_progress::where('user_id', $userId)
            ->pluck('course_content_id')
            ->toArray();

        $completedCount = count($completedIds);
        $progress = $totalContents > 0 ? ($completedCount / $totalContents) * 100 : 0;

        // 🚀 logika locked/unlocked
        $previousSectionCompleted = true;

        foreach ($course->sections as $section) {
            $section->locked = !$previousSectionCompleted;

            $allContentCompleted = true;

            foreach ($section->contents as $i => $content) {
                if ($section->locked) {
                    $content->locked = true;
                    $content->completed = in_array($content->id, $completedIds);
                    $allContentCompleted = false;
                } else {
                    if ($i === 0) {
                        $content->locked = false;
                    } else {
                        $prev = $section->contents[$i - 1];
                        $content->locked = !in_array($prev->id, $completedIds);
                    }
                    $content->completed = in_array($content->id, $completedIds);

                    if (!$content->completed) {
                        $allContentCompleted = false;
                    }
                }
            }

            $previousSectionCompleted = $allContentCompleted;
        }

        return view('student.course-detail', compact(
            'course',
            'progress',
            'totalContents',
            'completedCount'
        ));
    }

    public function markComplete($id)
    {
        $content = course_content::findOrFail($id);
        $user = auth()->user();

        // Simpan progress
        $user->completedContents()->syncWithoutDetaching([$content->id]);
        $user->load('completedContents');

        // Hitung progress
        $course = $content->section->course;
        $totalContents = $course->sections->flatMap->contents->count();
        $completedContents = $user->completedContents()->whereIn(
            'course_contents.id',
            $course->sections->flatMap->contents->pluck('id')
        )->count();
        $progress = $totalContents > 0 ? round(($completedContents / $totalContents) * 100) : 0;

        // 🔑 Tentukan section berikutnya yang boleh di-unlock
        $unlockedSections = [];
        foreach ($course->sections as $section) {
            $allCompleted = $section->contents->every(function ($c) use ($user) {
                return $user->completedContents->contains($c->id);
            });

            if ($allCompleted) {
                $sections = $course->sections->sortBy('order')->values();
                foreach ($sections as $index => $section) {
                    $allCompleted = $section->contents->every(fn($c) => $user->completedContents->contains($c->id));
                    if ($allCompleted && isset($sections[$index + 1])) {
                        $unlockedSections[] = $sections[$index + 1]->id;
                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'progress' => $progress,
            'unlocked_sections' => $unlockedSections,
            'unlocked_contents' => $course->sections->flatMap(function ($section) use ($user) {
                return $section->contents->map(function ($content, $i) use ($section, $user) {
                    $prevCompleted = $i === 0 || $user->completedContents->contains($section->contents[$i-1]->id);
                    if ($prevCompleted && !$user->completedContents->contains($content->id)) {
                        return [
                            'id' => $content->id,
                            'section_id' => $section->id,
                        ];
                    }
                    return null;
                })->filter();
            })->values()
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
