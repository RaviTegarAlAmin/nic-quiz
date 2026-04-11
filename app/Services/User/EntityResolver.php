<?php

namespace App\Services\User;

use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class EntityResolver
{

    public function resolve(User $user) :Teacher|Student|Admin|null
    {
        $entity = Cache::remember('user:'.$user->id.':entity', now()->addHours(8), function () use ($user) {
            return $user->student ?? $user->teacher ?? $user->admin ?? null;
        });

        return $entity;
    }

    public function forget(User $user) :void {

        Cache::forget('user:'.$user->id.':entity');

    }


}
