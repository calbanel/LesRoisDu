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

        $plateau12 = new Plateau();
        $plateau12->setNom("12 cases");
        $plateau12->setDescription("Un jolie plato tiens tiens tiens");
        $plateau12->setNiveauDifficulte("Facile");

        $manager->persist($plateau12);

        $plateau13 = new Plateau();
        $plateau13->setNom("13 cases");
        $plateau13->setDescription("Un jolie plato tiens tiens tiens");
        $plateau13->setNiveauDifficulte("Facile");

        $manager->persist($plateau13);

        $plateau14 = new Plateau();
        $plateau14->setNom("14 cases");
        $plateau14->setDescription("Un jolie plato tiens tiens tiens");
        $plateau14->setNiveauDifficulte("Facile");

        $manager->persist($plateau14);

        $plateau15 = new Plateau();
        $plateau15->setNom("15 cases");
        $plateau15->setDescription("Un jolie plato tiens tiens tiens");
        $plateau15->setNiveauDifficulte("Facile");

        $manager->persist($plateau15);

        $plateau16 = new Plateau();
        $plateau16->setNom("16 cases");
        $plateau16->setDescription("Un jolie plato tiens tiens tiens");
        $plateau16->setNiveauDifficulte("Facile");

        $manager->persist($plateau16);

        $plateau17 = new Plateau();
        $plateau17->setNom("17 cases");
        $plateau17->setDescription("Un jolie plato tiens tiens tiens");
        $plateau17->setNiveauDifficulte("Facile");

        $manager->persist($plateau17);

        $plateau18 = new Plateau();
        $plateau18->setNom("18 cases");
        $plateau18->setDescription("Un jolie plato tiens tiens tiens");
        $plateau18->setNiveauDifficulte("Facile");

        $manager->persist($plateau18);

       	$tabCases = array();
        for ($i=0; $i < 12; $i++) {
            $cases = new Cases();
            $cases->setDescriptifDefi($faker->realText($maxNbChars = 100, $indexSize = 2))
                ->setConsignes($faker->realText($maxNbChars = 400, $indexSize = 2))
                ->setCodeValidation($faker->randomNumber($nbDigits = 5, $strict = false))
                ->setPlateau($plateau12)
            ;
            
            array_push($tabCases, $cases);
            $manager->persist($cases);
        }

        for ($i=0; $i < 13; $i++) {
            $cases = new Cases();
            $cases->setDescriptifDefi($faker->realText($maxNbChars = 100, $indexSize = 2))
                ->setConsignes($faker->realText($maxNbChars = 400, $indexSize = 2))
                ->setCodeValidation($faker->randomNumber($nbDigits = 5, $strict = false))
                ->setPlateau($plateau13)
            ;
            
            array_push($tabCases, $cases);
            $manager->persist($cases);
        }

        for ($i=0; $i < 14; $i++) {
            $cases = new Cases();
            $cases->setDescriptifDefi($faker->realText($maxNbChars = 100, $indexSize = 2))
                ->setConsignes($faker->realText($maxNbChars = 400, $indexSize = 2))
                ->setCodeValidation($faker->randomNumber($nbDigits = 5, $strict = false))
                ->setPlateau($plateau14)
            ;
            
            array_push($tabCases, $cases);
            $manager->persist($cases);
        }

        for ($i=0; $i < 15; $i++) {
            $cases = new Cases();
            $cases->setDescriptifDefi($faker->realText($maxNbChars = 100, $indexSize = 2))
                ->setConsignes($faker->realText($maxNbChars = 400, $indexSize = 2))
                ->setCodeValidation($faker->randomNumber($nbDigits = 5, $strict = false))
                ->setPlateau($plateau15)
            ;
            
            array_push($tabCases, $cases);
            $manager->persist($cases);
        }

        for ($i=0; $i < 16; $i++) {
            $cases = new Cases();
            $cases->setDescriptifDefi($faker->realText($maxNbChars = 100, $indexSize = 2))
                ->setConsignes($faker->realText($maxNbChars = 400, $indexSize = 2))
                ->setCodeValidation($faker->randomNumber($nbDigits = 5, $strict = false))
                ->setPlateau($plateau16)
            ;
            
            array_push($tabCases, $cases);
            $manager->persist($cases);
        }

        for ($i=0; $i < 17; $i++) {
            $cases = new Cases();
            $cases->setDescriptifDefi($faker->realText($maxNbChars = 100, $indexSize = 2))
                ->setConsignes($faker->realText($maxNbChars = 400, $indexSize = 2))
                ->setCodeValidation($faker->randomNumber($nbDigits = 5, $strict = false))
                ->setPlateau($plateau17)
            ;
            
            array_push($tabCases, $cases);
            $manager->persist($cases);
        }

        for ($i=0; $i < 18; $i++) {
            $cases = new Cases();
            $cases->setDescriptifDefi($faker->realText($maxNbChars = 100, $indexSize = 2))
                ->setConsignes($faker->realText($maxNbChars = 400, $indexSize = 2))
                ->setCodeValidation($faker->randomNumber($nbDigits = 5, $strict = false))
                ->setPlateau($plateau18)
            ;
            
            array_push($tabCases, $cases);
            $manager->persist($cases);
        }

        for ($i=0; $i < 100; $i++) {

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
