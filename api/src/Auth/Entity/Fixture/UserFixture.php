<?php

namespace Auth\Entity\Fixture;

use Auth\Entity\User\Email;
use Auth\Entity\User\Id;
use Auth\Entity\User\Token;
use Auth\Entity\User\User;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class UserFixture extends AbstractFixture
{
    // 'password'
    private const PASSWORD_HASH = '$2y$12$qwnND33o8DGWvFoepotSju7eTAQ6gzLD/zy6W8NCVtiHPbkybz.w6';

    public function load(ObjectManager $manager): void
    {
        $user = User::create(
            new Id('00000000-0000-0000-0000-000000000001'),
            $date = new DateTimeImmutable('-30 days'),
            new Email('user@app.test'),
            self::PASSWORD_HASH,
            new Token($value = Uuid::uuid4()->toString(), $date->modify('+1 day'))
        );

        $manager->persist($user);

        $manager->flush();
    }
}