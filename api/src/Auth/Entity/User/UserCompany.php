<?php

declare(strict_types=1);

namespace Auth\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(readOnly: true)]
#[ORM\Table(name: 'auth_user_company')]
#[ORM\UniqueConstraint(columns: ['company_inn', 'company_ogrn'])]
final class UserCompany
{
    #[ORM\Column(type: 'guid')]
    #[ORM\Id]
    private string $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'company')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private User $user;

    #[ORM\Embedded(class: Company::class)]
    private Company $company;

    public function __construct(User $user, Company $company)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->user = $user;
        $this->company = $company;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Company
     */
    public function getCompany(): Company
    {
        return $this->company;
    }


}
