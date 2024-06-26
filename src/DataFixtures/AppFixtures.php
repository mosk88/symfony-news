<?php

namespace App\DataFixtures;

use App\Entity\ApiToken;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\VarExporter\Internal\Values;

class AppFixtures extends Fixture
{
    // public function __construct(private UserPasswordHasherInterface $passhasher)
    // {
    // }
    private const CATEGORIES  = ['Technology','Health','Sports','Entretainment','Politics'];

    private const ARTICLES_NB = 20;
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $list = [];
        
        foreach (self::CATEGORIES as $namecategory ) {
            $category = new Category();
            $category
                ->setName($namecategory);
           
            $manager ->persist($category);
             $list [] = $category ;
           
        $manager->persist($category);
        }
      
        for ($i = 0; $i < self::ARTICLES_NB; $i++) {
            $article = new Article();
            $article
                ->setTitle($faker->words(3, true))
                ->setContent($faker->realTextBetween(300, 500))
                ->setCreatedAt($faker->dateTime('-2'))
                ->setVisible($faker->boolean(80))
                ->setPictureFilename('localhost:8000/api/articles')
                ->setCategory($faker->randomElement($list));
                $manager->persist($article);

    }
    $user = new User();
        $user
            ->setEmail('user@tit.net')
            ->setPassword('test')
            ->setRoles(['ROLE_USER']);
            $manager->persist($user);

        $admin = new User();
        $admin
            ->setEmail('admin@tit.net')
            ->setPassword('admin')
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

$token = new ApiToken();
        $token->setToken('MlXbRwjGc3muZMqEVjIfmoo6X');
      
        $manager->persist($token);
    //envoyer les donnes vers BBD
      $manager->flush();
}
}