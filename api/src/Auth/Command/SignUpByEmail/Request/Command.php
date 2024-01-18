<?php

declare(strict_types=1);

namespace App\Auth\Command\SignUpByEmail\Request;

final class Command
{
    public string $email = '';
    public string $password = '';
}
