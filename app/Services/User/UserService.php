<?php

namespace App\Services\User;

use Storage;

class UserService
{
    protected $instance = null;

    public function __construct($instance)
    {
        /* @var \App\Models\User\User $instance */
        $this->instance = $instance;
    }

    public function withAvatar()
    {
        $avatar = $this->instance->getMedia('avatar')->last();

        if ($avatar) {
            $this->instance->avatar = collect();

            $this->instance->avatar->push([
                'id' => $avatar->id,
                'url' => $avatar->getUrl(),
                'name' => $avatar->getCustomProperty('name'),
                'desc' => $avatar->getCustomProperty('desc')
            ]);
        }

        return $this;
    }

    public function get()
    {
        return $this->instance;
    }
}
