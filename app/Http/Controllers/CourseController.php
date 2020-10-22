<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseWithEpisodes;
use App\Models\Course;
use App\Models\Episode;
use App\Youtube\YoutubeServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $courses = Course::with('user')
            ->select('courses.*', DB::raw(
                '(SELECT COUNT(DISTINCT(user_id))
                FROM completions
                INNER JOIN episodes ON completions.episode_id = episodes.id
                WHERE episodes.course_id = courses.id) AS participants'
            ))
            /* add column duration*/
            ->addSelect(DB::raw(
                '(SELECT SUM(duration)
                FROM episodes
                WHERE episodes.course_id = courses.id
                ) AS total_duration'
            ))
            ->withCount('episodes')->latest()->paginate(5);
        return Inertia::render('Courses/Index', [
            'courses' => $courses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCourseWithEpisodes $request
     * @param YoutubeServices $ytb
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCourseWithEpisodes $request, YoutubeServices $ytb)
    {
        $course = Course::create($request->all());

        foreach ($request->input('episodes') as $episode) {
            $episode['course_id'] = $course->id;
            $episode['duration']  = $ytb->handleYoutubeVideoDuration($episode['video_url']);
            Episode::create($episode);
        }

        return Redirect::route('courses.index')->with('success', 'Congratulations! The course has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function show($id)
    {
        $course  = Course::where('id', $id)->with('episodes')->first();
        $watched = auth()->user()->episodes;
        return Inertia::render('Courses/Show', [
            'course'  => $course,
            'watched' => $watched
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function edit($id)
    {
        $course = Course::where('id', $id)->with('episodes')->first();
        $this->authorize('update', $course);
        return Inertia::render('Courses/Edit', [
            'course' => $course,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $course = Course::where('id', $request->id)->with('episodes')->first();
        $this->authorize('update', $course);
        $course->update($request->all());

        // Delete all episodes from the course
        $course->episodes()->delete();

        // Create all episodes again as they are modified
        foreach ($request->episodes as $episode) {
            $episode['course_id'] = $course->id;
            Episode::create($episode);
        }
        return Redirect::route('courses.index')->with('success', 'Congratulations! The course has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function toggleProgress(Request $request)
    {
        $id   = $request->input('episodeId');
        $user = auth()->user();
        $user->episodes()->toggle($id);
        return $user->episodes;
    }
}
