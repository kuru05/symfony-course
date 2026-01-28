<?php

namespace App\DataFixtures; // DOIT ÊTRE ICI (Ligne 3)

use App\Entity\Article;    // Les imports viennent ensuite
use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        // Création des catégories
        $categories = [];
        foreach (['Tech', 'Actu', 'Sport'] as $name) {
            $cat = new Categories();
            $cat->setName($name);
            $manager->persist($cat);
            $categories[] = $cat;
        }

        // Création des articles liés
        for ($i = 0; $i < 20; $i++) {
            $article = new Article();
            $article->setTitle($faker->sentence())
                    ->setContent($faker->paragraphs(3, true))
                    ->setCreatedAt(new \DateTimeImmutable())
                    ->setCategory($categories[array_rand($categories)]); 
            $manager->persist($article);
        }

        $manager->flush(); 
    }
}