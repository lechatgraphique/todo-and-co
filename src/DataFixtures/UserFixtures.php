<?php


namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private UserPasswordEncoderInterface $encoder;

    public const ADMIN_REFERENCE = 'ADMIN';
    public const USER_REFERENCE = 'USER';
    public const ANONYMOUS_REFERENCE = 'ANONYMOUS';

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 4; $i++) {
            $user = new User();

            if ($i == 1) {
                $user
                    ->setUsername('admin' . $i)
                    ->setEmail(strtolower('admin' . $i . '@gmail.com'))
                    ->setPassword($this->encoder->encodePassword($user, '12345'))
                    ->setRoles(['ROLE_ADMIN']);

                $manager->persist($user);

                $this->setReference(self::ADMIN_REFERENCE . "$i", $user);

            } elseif ($i == 2) {
                $user
                    ->setUsername('anonymous' . $i)
                    ->setEmail(strtolower('anonymous' . $i . '@gmail.com'))
                    ->setPassword($this->encoder->encodePassword($user, '12345'))
                    ->setRoles(['ROLE_USER']);

                $manager->persist($user);

                $this->setReference(self::USER_REFERENCE . "$i", $user);
            } elseif ($i == 3) {
                $user
                    ->setUsername('user' . $i)
                    ->setEmail(strtolower('user' . $i . '@gmail.com'))
                    ->setPassword($this->encoder->encodePassword($user, '12345'))
                    ->setRoles(['ROLE_USER']);

                $manager->persist($user);

                $this->setReference(self::USER_REFERENCE . "$i", $user);
            }
        }

        $manager->flush();
    }
}