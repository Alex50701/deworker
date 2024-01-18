<?php

declare(strict_types=1);

namespace Auth\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Embeddable]
final class City
{
    #[ORM\Column(type: 'guid')]
    #[ORM\Id]
    private string $id;

    #[ORM\Column(type: 'string')]
    private string $name;

    public function __construct(string $name)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->name = $name;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
