<?php

declare(strict_types=1);

namespace Auth\Entity\User;

use Auth\Entity\User\Email;


interface UserRepository
{
    public function hasByEmail(Email $email): bool;
    public function add(User $user): void;
}