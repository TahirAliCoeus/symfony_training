<?php

namespace App\Event;

use App\Entity\User;

class UserDeletedEvent
{
    public const NAME = 'user.deleted';

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): string
    {
        return "i was deleted";
    }
}