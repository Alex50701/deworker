<?php

declare(strict_types=1);

namespace Auth\Entity\User;

final class Email
{
    private string $value;

    public function __construct(string $value)
    {
        // Assert::notEmpty($value);
        // Assert::email($value);
        $this->value = mb_strtolower($value);
    }

    public function isEqualTo(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
