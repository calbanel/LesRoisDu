<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Plateau;
use App\Entity\Cases;
use App\Entity\Ressource;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        $plateau = new Plateau();
        $plateau->setNom("Le Plato");
        $plateau->setDescription("Un jolie plato tiens tiens tiens");
        $plateau->setNiveauDifficulte("Facile");

        $manager->persist($plateau);

       	$tabCases = array();
        for ($i=0; $i < 12; $i++) {
            $cases = new Cases();
            $cases->setDescriptifDefi($faker->realText($maxNbChars = 100, $indexSize = 2))
                ->setConsignes($faker->realText($maxNbChars = 400, $indexSize = 2))
                ->setCodeValidation($faker->randomNumber($nbDigits = 5, $strict = false))
                ->setPlateau($plateau)
            ;
            
            array_push($tabCases, $cases);
            $manager->persist($cases);
        }

        for ($i=0; $i < 10; $i++) {

            $ressource = new Ressource();

            $ressource->setChemin($faker->imageUrl($width = 200,$height = 200,'cats'));

            $case = $faker->randomElement($array = $tabCases);
            $ressource->setCases($case);
            $case->addRessource($ressource);
            $manager->persist($case);
            
            $manager->persist($ressource);
        }

        $manager->flush();
    }
}
