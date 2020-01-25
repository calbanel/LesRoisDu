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
        $plateau->setNom("12 cases");
        $plateau->setDescription("Un jolie plato tiens tiens tiens");
        $plateau->setNiveauDifficulte("Facile");

        $manager->persist($plateau12);

        $plateau13 = new Plateau();
        $plateau->setNom("13 cases");
        $plateau->setDescription("Un jolie plato tiens tiens tiens");
        $plateau->setNiveauDifficulte("Facile");

        $manager->persist($plateau13);

        $plateau14 = new Plateau();
        $plateau->setNom("14 cases");
        $plateau->setDescription("Un jolie plato tiens tiens tiens");
        $plateau->setNiveauDifficulte("Facile");

        $manager->persist($plateau14);

        $plateau15 = new Plateau();
        $plateau->setNom("15 cases");
        $plateau->setDescription("Un jolie plato tiens tiens tiens");
        $plateau->setNiveauDifficulte("Facile");

        $manager->persist($plateau15);

        $plateau16 = new Plateau();
        $plateau->setNom("16 cases");
        $plateau->setDescription("Un jolie plato tiens tiens tiens");
        $plateau->setNiveauDifficulte("Facile");

        $manager->persist($plateau16);

        $plateau17 = new Plateau();
        $plateau->setNom("17 cases");
        $plateau->setDescription("Un jolie plato tiens tiens tiens");
        $plateau->setNiveauDifficulte("Facile");

        $manager->persist($plateau17);

        $plateau18 = new Plateau();
        $plateau->setNom("18 cases");
        $plateau->setDescription("Un jolie plato tiens tiens tiens");
        $plateau->setNiveauDifficulte("Facile");

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
