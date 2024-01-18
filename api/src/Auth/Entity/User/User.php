<?php

declare(strict_types=1);

namespace Auth\Entity\User;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'auth_users')]
class User
{
    #[ORM\Column(type: 'auth_user_id')]
    #[ORM\Id]
    private Id $id;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $date;

    #[ORM\Column(type: 'auth_user_email', unique: true)]
    private Email $email;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $passwordHash = null;

    #[ORM\Embedded(class: Token::class)]
    private ?Token $joinConfirmToken = null;

    /**
     * @var Collection<array-key,UserCompany>
     */
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserCompany::class, cascade: ['all'], orphanRemoval: true)]
    private Collection $company;

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

    #[ORM\PostLoad]
    public function checkEmbeds(): void
    {
        if ($this->joinConfirmToken && $this->joinConfirmToken->isEmpty()) {
            $this->joinConfirmToken = null;
        }
    }

    /**
     * @return Company[]
     */
    public function getUserCompany(): array
    {
        /** @var Company[] */
        return $this->company->map(static fn(UserCompany $company) => $company->getCompany())->toArray();
    }

    public function setCompany(
        Id                $id,
        DateTimeImmutable $date,
        Email             $email,
        Company           $company
    ): self
    {
        $user = new self($id, $date, $email);
        $this->company->add(new UserCompany($user, $company));
        return $user;
    }


    public static function create(
        Id                $id,
        DateTimeImmutable $date,
        Email             $email,
        ?string           $passwordHash,
        ?Token            $joinConfirmToken
    ): self
    {
        $user = new self();
        $user->id = $id;
        $user->date = $date;
        $user->email = $email;
        $user->passwordHash = $passwordHash;
        $user->joinConfirmToken = $joinConfirmToken;
        return $user;
    }


}
