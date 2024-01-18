<?php

namespace Auth\Entity\Fixture;

use Auth\Entity\User\City;
use Auth\Entity\User\Company;
use Auth\Entity\User\Email;
use Auth\Entity\User\Id;
use Auth\Entity\User\Token;
use Auth\Entity\User\User;
use Auth\Entity\User\UserCompany;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class CompanyFixture extends AbstractFixture
{
    private const INN = 86030015;
    private const OGRN = 1000564;
    private const PASSWORD_HASH = '$2y$12$qwnND33o8DGWvFoepotSju7eTAQ6gzLD/zy6W8NCVtiHPbkybz.w6';

    public function load(ObjectManager $manager): void
    {

        $city = new City('Нижневартовск');

        $company = new Company('Рога и копыта', self::INN, self::OGRN, $city);

        $user = User::create(
            new Id('00000000-0000-0000-0000-000000000002'),
            $date = new DateTimeImmutable('-30 days'),
            new Email('company@app.test'),
            self::PASSWORD_HASH,
            new Token($value = Uuid::uuid4()->toString(), $date->modify('+1 day'))
        );

        $userCompany = new UserCompany($user, $company);

        $manager->persist($user);
        $manager->persist($userCompany);

        $manager->flush();
    }
}