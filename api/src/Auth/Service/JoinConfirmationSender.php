<?php


namespace Auth\Service;


use Auth\Entity\User\Email;

interface JoinConfirmationSender
{
    public function send(Email $email, string $token): void;
}