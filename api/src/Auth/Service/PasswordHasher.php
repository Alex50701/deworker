<?php


namespace Auth\Service;


interface PasswordHasher
{
    public function hash(string $password): string;
    public function validate(string $password, string $hash): bool;
}