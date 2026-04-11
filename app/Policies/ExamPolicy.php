<?php

namespace App\Policies;

use App\Models\Exam;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Services\User\EntityResolver;
use Illuminate\Auth\Access\Response;

class ExamPolicy
{

    public function __construct(protected EntityResolver $resolver)
    {
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Exam $exam): bool
    {
        $entity = $this->resolver->resolve($user);

        if ($entity instanceof Student) {
            return $entity->hasExam($exam);
        }

        if ($entity instanceof Teacher) {
            return $entity->id === $exam->teacher_id;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $entity = $this->resolver->resolve($user);

        return $entity instanceof Teacher;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Exam $exam): bool
    {
        $entity = $this->resolver->resolve($user);

        return $entity instanceof Teacher && $entity->id === $exam->teacher_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Exam $exam): bool
    {
        $entity = $this->resolver->resolve($user);

        return $entity instanceof Teacher && $entity->id === $exam->teacher_id;
    }

    /**
     * Determine whether the user can attempt the exam.
     */
    public function attempt(User $user, Exam $exam): bool
    {
        $entity = $this->resolver->resolve($user);

        return $entity instanceof Student && $entity->hasExam($exam);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Exam $exam): bool
    {
        $entity = $this->resolver->resolve($user);

        return $entity instanceof Teacher && $entity->id === $exam->teacher_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Exam $exam): bool
    {
        $entity = $user->entity();

        return $entity instanceof Teacher && $entity->id === $exam->teacher_id;
    }
}
