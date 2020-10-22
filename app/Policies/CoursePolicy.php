<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /*
     * Authorisation policies to update the course
     * Authorise only the the course's author to modify its content
     * */
    public function update(User $user, Course $course)
    {
        return $user->id === $course->user_id;
    }
}
