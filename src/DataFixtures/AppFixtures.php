<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\Booking;
use App\Entity\Image;
use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR-fr');

        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        $adminUser = new User();
        $adminUser
            ->setFirstname('Guillaume')
            ->setLastname('D.')
            ->setEmail('guiguisleaze2@gmail.com')
            ->setHash($this->encoder->encodePassword($adminUser, 'password'))
            ->setPicture('https://gdlab.fr/img/guillaume.jpg')
            ->setIntroduction($faker->sentence())
            ->setDescription($faker->paragraph(3))
            ->addUserRole($adminRole);

        $manager->persist($adminUser);

        //users management
        $users = [];
        $genres = ['male', 'female'];

        for ($i = 1; $i <= 10; $i++) {
            $user = new User();

            $genre = $faker->randomElement($genres);
            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1, 99).'.jpg';

            $hash = $this->encoder->encodePassword($user, 'password');

            if ($genre === 'male') {
                $picture = $picture.'men/'.$pictureId;
            } else {
                $picture = $picture.'women/'.$pictureId;
            }

            $user
                ->setFirstname($faker->firstName($genre))
                ->setLastname($faker->lastName)
                ->setEmail($faker->email)
                ->setIntroduction($faker->sentence())
                ->setDescription('<p>'.implode('</p><p>', $faker->paragraphs(2)).'</p>')
                ->setHash($hash)
                ->setPicture($picture);

            $manager->persist($user);
            $users[] = $user;


        }

        //ads management
        for ($i = 1; $i <= 30; $i++) {
            $ad = new Ad();
            $title = $faker->sentence();

            $coverImage = $faker->imageUrl(1920, 1080);
            $introduction = $faker->paragraph(2);
            $content = '<p>'.implode('</p><p>', $faker->paragraphs(5)).'</p>';
            $user = $users[mt_rand(0, count($users) - 1)];

            $ad
                ->setTitle($title)
                ->setCoverImage($coverImage)
                ->setIntroduction($introduction)
                ->setContent($content)
                ->setPrice(mt_rand(40, 200))
                ->setRooms(mt_rand(1, 6))
                ->setAuthor($user);

            for ($j = 1; $j <= mt_rand(2, 5); $j++) {
                $image = new Image();

                $image
                    ->setUrl($faker->imageUrl())
                    ->setCaption($faker->sentence())
                    ->setAd($ad);
                $manager->persist($image);
            }

            //booking management
            for ($j = 1; $j <= mt_rand(0, 10); $j++) {
                $booking = new Booking();

                $createdAt = $faker->dateTimeBetween('-6 months');
                $startDate = $faker->dateTimeBetween('-3 months');

                $duration = mt_rand(3, 10);

                // we have to clone startDate because if not, startDate will be modified too
                $endDate = (clone $startDate)->modify("+$duration days");
                $amount = $ad->getPrice() * $duration;

                $booker = $users[mt_rand(0, count($users) - 1)];
                $comment = $faker->paragraph();

                $booking
                    ->setBooker($booker)
                    ->setAd($ad)
                    ->setStartDate($startDate)
                    ->setEndDate($endDate)
                    ->setCreatedAt($createdAt)
                    ->setAmount($amount)
                    ->setComment($comment);

                $manager->persist($booking);
            }

            $manager->persist($ad);
        }

        $manager->flush();
    }
}
