<?php


namespace Auth\Entity\User;


use DateTimeImmutable;

class User
{
    private DateTimeImmutable $date;
    private Email $email;
    private string $passwordHash;
    private ?string $joinConfirmToken;

    public function __construct(
        DateTimeImmutable $date,
        Email $email,
        string $passwordHash,
        string $token
    ) {
        $this->date = $date;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->joinConfirmToken = $token;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPasswordHash(): ?string
    {
        return $this->passwordHash;
    }

    public function getJoinConfirmToken(): ?string
    {
        return $this->joinConfirmToken;
    }
}