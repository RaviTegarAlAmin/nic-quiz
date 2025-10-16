<?php

namespace App\Policies;

use App\Models\User;

class StudentExamPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function examtaker(User $user){

    }
}
