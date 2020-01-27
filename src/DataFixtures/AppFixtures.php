<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Plateau;
use App\Entity\PlateauEnJeu;
use App\Entity\Pion;
use App\Entity\Cases;
use App\Entity\Ressource;
use App\Entity\Utilisateur;
use App\Entity\Partie;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        $plateau12 = new Plateau();
        $plateau12->setNom("12 cases");
        $plateau12->setDescription($faker->realText($maxNbChars = 400, $indexSize = 2));
        $plateau12->setNiveauDifficulte("Facile");

        $manager->persist($plateau12);

        $plateau13 = new Plateau();
        $plateau13->setNom("13 cases");
        $plateau13->setDescription($faker->realText($maxNbChars = 400, $indexSize = 2));
        $plateau13->setNiveauDifficulte("Difficile");

        $manager->persist($plateau13);

        $plateau14 = new Plateau();
        $plateau14->setNom("14 cases");
        $plateau14->setDescription($faker->realText($maxNbChars = 400, $indexSize = 2));
        $plateau14->setNiveauDifficulte("Difficile");

        $manager->persist($plateau14);

        $plateau15 = new Plateau();
        $plateau15->setNom("15 cases");
        $plateau15->setDescription($faker->realText($maxNbChars = 400, $indexSize = 2));
        $plateau15->setNiveauDifficulte("Facile");

        $manager->persist($plateau15);

        $plateau16 = new Plateau();
        $plateau16->setNom("16 cases");
        $plateau16->setDescription("Et merci bien");
        $plateau16->setNiveauDifficulte("Moyen");

        $manager->persist($plateau16);

        $plateau17 = new Plateau();
        $plateau17->setNom("17 cases");
        $plateau17->setDescription($faker->realText($maxNbChars = 400, $indexSize = 2));
        $plateau17->setNiveauDifficulte("Facile");

        $manager->persist($plateau17);

        $plateau18 = new Plateau();
        $plateau18->setNom("18 cases");
        $plateau18->setDescription($faker->realText($maxNbChars = 400, $indexSize = 2));
        $plateau18->setNiveauDifficulte("Moyen");

        $manager->persist($plateau18);

        $utilisateur1 = new Utilisateur();
        $utilisateur1->setPseudo("calbanel");
        $utilisateur1->setMotDePasse("mcb");
        $utilisateur1->setAdresseMail("clement.albanel@gmail.com");
        $utilisateur1->setNom("Albanel");
        $utilisateur1->setPrenom("Clement");
        $utilisateur1->setEstInvite(false);
        $utilisateur1->setAvatar($faker->imageUrl($width = 200,$height = 200,'cats'));

        $utilisateur2 = new Utilisateur();
        $utilisateur2->setPseudo("eauzi");
        $utilisateur2->setMotDePasse("souce");
        $utilisateur2->setAdresseMail("emma.auzi@gmail.com");
        $utilisateur2->setNom("Auzi");
        $utilisateur2->setPrenom("Emma");
        $utilisateur2->setEstInvite(false);
        $utilisateur2->setAvatar($faker->imageUrl($width = 200,$height = 200,'cats'));

        $plateauEnJeu = new PlateauEnJeu();
        $plateauEnJeu->setNom("16 cases");
        $plateauEnJeu->setDescription("Et merci bien");
        $plateauEnJeu->setNiveauDifficulte("Moyen");

        $partie = new Partie();
        $partie->setPlateau($plateau16);
        $partie->setPlateauDeJeu($plateauEnJeu);
        $partie->setCreateur($utilisateur1);
        $partie->addJoueur($utilisateur2);
        $partie->setNom("Partie De Clém");
        $partie->setDescription("Partie carrément incroyable !");
        $partie->setCode("ABCDE");

        $utilisateur1->addPartiesCree($partie);
        $utilisateur2->addPartiesRejoin($partie);

        $plateauEnJeu->setJoueur($utilisateur2);

        $plateauEnJeu->setPartie($partie);


        $utilisateur1->addPlateau($plateau16);
        $utilisateur1->addPlateauEnJeux($plateauEnJeu);

        $manager->persist($utilisateur1);
        $manager->persist($utilisateur2);
        $manager->persist($partie);

        $pion1 = new Pion();
        $pion1->setNom("clem");
        $pion1->setCouleur("12578");
        $pion1->setAvancementPlateau(2);
        $pion1->setPlateauEnJeu($plateauEnJeu);

        $manager->persist($pion1);

        $pion2 = new Pion();
        $pion2->setNom("emma");
        $pion2->setCouleur("12878");
        $pion2->setAvancementPlateau(5);
        $pion2->setPlateauEnJeu($plateauEnJeu);

        $manager->persist($pion2);

        $pion3 = new Pion();
        $pion3->setNom("bastos");
        $pion3->setCouleur("12678");
        $pion3->setAvancementPlateau(4);
        $pion3->setPlateauEnJeu($plateauEnJeu);

        $manager->persist($pion3);

        $pion4 = new Pion();
        $pion4->setNom("chris");
        $pion4->setCouleur("12278");
        $pion4->setAvancementPlateau(7);
        $pion4->setPlateauEnJeu($plateauEnJeu);

        $manager->persist($pion4);

        $plateauEnJeu->addPion($pion1);
        $plateauEnJeu->addPion($pion2);
        $plateauEnJeu->addPion($pion3);
        $plateauEnJeu->addPion($pion4);

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

        $cases16 = array();
        for ($i=0; $i < 16; $i++) {
            $cases = new Cases();
            $cases->setDescriptifDefi($faker->realText($maxNbChars = 100, $indexSize = 2))
                ->setConsignes($faker->realText($maxNbChars = 400, $indexSize = 2))
                ->setCodeValidation($faker->randomNumber($nbDigits = 5, $strict = false))
            ;

            array_push($cases16, $cases);
            $cases->setPlateau($plateau16);
            
            array_push($tabCases, $cases);
            $manager->persist($cases);
        }

        for ($i=0; $i < 16; $i++) {
        	$cases = new Cases();
            $cases->setDescriptifDefi($cases16[$i]->getDescriptifDefi())
                ->setConsignes($cases16[$i]->getConsignes())
                ->setCodeValidation($cases16[$i]->getCodeValidation())
            ;
            $cases->setPlateauEnJeu($plateauEnJeu);
            $plateauEnJeu->addCase($cases);

            array_push($tabCases, $cases);
            $manager->persist($cases);

        }
        $manager->persist($plateauEnJeu);

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

        for ($i=0; $i < 200; $i++) {

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
