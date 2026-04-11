<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Services\User\EntityResolver;
use Illuminate\Auth\Access\Response;

class QuestionPolicy
{

    protected function __construct(
        protected EntityResolver $resolver,
        protected $entity
    ) {
        $this->entity = $this->resolver->resolve(auth()->user());
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->teacher) {
            return true;
        }

        if ($user->student) {

        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Question $question): bool
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
    public function update(User $user, Question $question): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Question $question): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Question $question): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Question $question): bool
    {
        return false;
    }
}
