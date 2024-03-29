<?php

declare(strict_types=1);

namespace Auth\Entity\User;

use Ramsey\Uuid\Uuid;

final class Id
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = mb_strtolower($value);
    }

    public function __toString(): string
    {
        return $this->getValue();
    }

    public static function generate(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
