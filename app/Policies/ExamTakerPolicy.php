<?php

namespace App\Policies;

use App\Models\ExamTaker;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ExamTakerPolicy
{
    public function owner(User $user, ExamTaker $examTaker): bool
    {
        return $user->student->id === $examTaker->student_id;
    }

    public function finished(User $user, ExamTaker $examTaker): bool
    {
        return $examTaker->examAssignment->status === 'finished';
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ExamTaker $examTaker): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ExamTaker $examTaker): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ExamTaker $examTaker): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ExamTaker $examTaker): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ExamTaker $examTaker): bool
    {
        return false;
    }
}
