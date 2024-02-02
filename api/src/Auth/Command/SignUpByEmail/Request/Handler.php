<?php

declare(strict_types=1);

namespace Auth\Command\SignUpByEmail\Request;

use App\Auth\Command\SignUpByEmail\Request\Command;
use App\Auth\Entity\User\UserRepository;
use Auth\Entity\User\Email;
use Auth\Entity\User\Id;
use Auth\Entity\User\Token;
use Auth\Entity\User\User;
use Auth\Flusher;
use Auth\Service\JoinConfirmationSender;
use Auth\Service\PasswordHasher;
use Auth\Service\Tokenizer;
use DateTimeImmutable;
use DomainException;
use Ramsey\Uuid\Uuid;

final class Handler
{
    private UserRepository $users;
    private PasswordHasher $hasher;
    private Tokenizer $tokenizer;
    private Flusher $flusher;
    private JoinConfirmationSender $sender;

    public function __construct(
        UserRepository $users,
        PasswordHasher $hasher,
        Tokenizer $tokenizer,
        Flusher $flusher,
        JoinConfirmationSender $sender
    ) {
        $this->users = $users;
        $this->hasher = $hasher;
        $this->tokenizer = $tokenizer;
        $this->flusher = $flusher;
        $this->sender = $sender;
    }

    public function handle(Command $command): void
    {
        $email = new Email($command->email);

        if ($this->users->hasByEmail($email)) {
            throw new DomainException('User already exists.');
        }

        $date = new DateTimeImmutable();
        $token  = new Token(Uuid::uuid4()->toString(), $date->modify('+1 day'));

        $user = User::create(
            Id::generate(),
            $date,
            new Email($command->email),
            $command->password,
            $token
        );

        $this->users->add($user);

        $this->flusher->flush();

        $this->sender->send($email, $token->getValue());
    }
}
