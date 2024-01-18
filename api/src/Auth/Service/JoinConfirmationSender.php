<?php

declare(strict_types=1);

namespace Auth\Service;

use Auth\Entity\User\Email;

interface JoinConfirmationSender
{
    public function send(Email $email, string $token): void;
}
