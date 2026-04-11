<?php

namespace App\Traits\Models;

use App\Services\User\EntityResolver;


/* This traits used to resolve entity related to user*/

trait HasEntity{


    protected $cachedEntity;

    public function entity(){

        return $this->cachedEntity??= app(EntityResolver::class)->resolve(auth()->user());
    }


}
