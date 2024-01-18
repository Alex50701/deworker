<?php

namespace Auth\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Embeddable]
class Company
{
    #[ORM\Column(type: 'guid')]
    #[ORM\Id]
    private string $id;

    #[ORM\Column(type: 'string')]
    private string $name;

    #[ORM\Column(type: 'integer', length: 12)]
    private int $inn;

    #[ORM\Column(type: 'integer', length: 16)]
    private int $ogrn;

    #[ORM\Embedded(class: City::class)]
    private City $city;

    public function __construct(string $name, int $inn, int $ogrn, City $city)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->name = $name;
        $this->inn = $inn;
        $this->ogrn = $ogrn;
        $this->city = $city;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getInn(): int
    {
        return $this->inn;
    }

    public function setInn(int $inn): void
    {
        $this->inn = $inn;
    }

    public function getOgrn(): int
    {
        return $this->ogrn;
    }

    public function setOgrn(int $ogrn): void
    {
        $this->ogrn = $ogrn;
    }

    public function getCity(): City
    {
        return $this->city;
    }

    public function setCity(City $city): void
    {
        $this->city = $city;
    }
}