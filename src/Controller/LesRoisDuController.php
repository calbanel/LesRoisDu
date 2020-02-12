<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Plateau;
use App\Entity\PlateauEnJeu;
use App\Entity\Pion;
use App\Entity\Cases;
use App\Entity\Ressource;
use App\Entity\Utilisateur;
use App\Entity\Partie;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class LesRoisDuController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index()
    {
        return $this->render('les_rois_du/index.html.twig');
    }

    /**
     * @Route("/connexion", name="page_connexion")
     */
    public function affichagePageConnexion()
    {
        return $this->render('les_rois_du/connexion.html.twig');
    }
    
    /**
     * @Route("/inscription", name="page_inscription")
     */
    public function affichagePageInscription(Request $request, ObjectManager $manager)
    {
        // Création d'une entrprise vierge
        $utilisateur=new Utilisateur();

        // Création de l'objet formulaire
        $formulaireUtilisateur=$this->createFormBuilder($utilisateur)
        ->add('Nom',TextType::class)
        ->add('Prenom',TextType::class)
        ->add('AdresseMail',EmailType::class)
        ->add('Pseudo',TextType::class)
        ->add('MotDePasse', RepeatedType::class, ['type'=>PasswordType::class,
                                                  'invalid_message'=> 'Les mots de passe doivent correspondre',
                                                  'options'=> ['attr' => ['class' => 'password-field']],
                                                  'required'=>true,
                                                  'first_options'=>['label'=>'Mot de passe'],
                                                  'second_options' => ['label' => 'Confirmez votre mot de passe']])
        ->add('Avatar',UrlType::class)        
        ->getForm();

        $formulaireUtilisateur->handleRequest($request);

        if ($formulaireUtilisateur->isSubmitted() && $formulaireUtilisateur->isValid())
        {        
           // l'utilisateur cree un compte il n'est donc pas invité
            $utilisateur->setEstInvite(false);
           
            // Enregistrer la ressource en base de données
           $manager->persist($utilisateur);
           $manager->flush();

           // Rediriger l'utilisateur vers la page d'accueil
           return $this->redirectToRoute('hub');
        }
        
        
        
        
        return $this->render('les_rois_du/inscription.html.twig',['vueFormulaireInscription' => $formulaireUtilisateur->createView()]);
    }

    /**
     * @Route("/hub", name="hub")
     */
    public function affichageHub()
    {
        return $this->render('les_rois_du/hub.html.twig');
    }

    /**
     * @Route("/parties", name="espace_partie")
     */
    public function affichageEspacePartie()
    {
        $repositoryPartie=$this->getDoctrine()->getRepository(Partie::class);
        $parties = $repositoryPartie->findAll();
        
        return $this->render('les_rois_du/espacepartie.html.twig', ['parties'=>$parties]);
    }

    /**
     * @Route("/TESTparties", name="TESTespace_partie")
     */
    public function affichageTESTEspacePartie()
    {
        
        
        return $this->render('les_rois_du/TESTespacepartie.html.twig');
    }

    /**
     * @Route("/compte", name="espace_compte")
     */
    public function affichageEspaceCompte()
    {
        return $this->render('les_rois_du/espacecompte.html.twig');
    }

 
    /**
     * @Route("/plateaux", name="espace_plateau")
     */
    public function affichageEspacePlateau()
    {
        $repositoryPlateaux=$this->getDoctrine()->getRepository(Plateau::class);
        $plateaux = $repositoryPlateaux->findAll();
        
        return $this->render('les_rois_du/espaceplateau.html.twig', ['plateaux'=>$plateaux]);
    }

    /**
     * @Route("/parties/creation", name="creation_partie")
     */
    public function affichageCreationPartie(Request $request, ObjectManager $manager)
    {
       
       // Création d'une entrprise vierge
       $partie=new Partie();

       // Création de l'objet formulaire
       $formulairePartie=$this->createFormBuilder($partie)
       ->add('Nom',TextType::class)
       ->add('Description',TextareaType::class)
       ->add('nbPlateaux',IntegerType::class,['data' => '1', 'disabled' => 'true'])
       ->add('nbPionParPlateau',IntegerType::class,['data' => '1', 'disabled' => 'true'])
       ->add('nbFacesDe',IntegerType::class,['data' => '4', 'disabled' => 'true'])
       ->add('plateau', EntityType::class, ['class' => Plateau::class,
                                                'choice_label' => 'nom',
                                                'multiple' => false,
                                                'expanded' => false])
       ->getForm();

       $formulairePartie->handleRequest($request);

       if ($formulairePartie->isSubmitted())
       {     
           $manager->persist($partie);
            $plateau = $partie->getPlateau(); 
            $plateau->addParty($partie);
            $manager->persist($plateau);
            
            $utilisateur1 = new Utilisateur();
          $utilisateur1->setPseudo("bastos");
          $utilisateur1->setMotDePasse("mcb");
          $utilisateur1->setAdresseMail("bastos.albanel@gmail.com");
          $utilisateur1->setNom("Albanel");
          $utilisateur1->setPrenom("Bastos");
          $utilisateur1->setEstInvite(false);
          $utilisateur1->setAvatar("https://www.google.com/url?sa=i&url=https%3A%2F%2Fgamergen.com%2Factualites%2Favatar-pandora-rising-possible-nom-jeu-ubisoft-na-vi-297799-1&psig=AOvVaw2OxTwThQuJ0fl5AtZ3FLGY&ust=1581271457638000&source=images&cd=vfe&ved=0CAIQjRxqFwoTCKjOqa_FwucCFQAAAAAdAAAAABAD");

            $plateauEnJeu= new PlateauEnJeu();
            $plateauEnJeu->setNiveauDifficulte($plateau->getNiveauDifficulte());
          $plateauEnJeu->setNom($plateau->getNom());
          $plateauEnJeu->setDescription($plateau->getDescription());

          $partie->setPlateauDeJeu($plateauEnJeu);

          $partie->setCreateur($utilisateur1);
          $partie->addJoueur($utilisateur1);

          $partie->setCode("Aghdd");

          $utilisateur1->addPartiesCree($partie);

          $utilisateur1->addPartiesRejoin($partie);

          $plateauEnJeu->setJoueur($utilisateur1);

            

            $plateauEnJeu->setPartie($partie);

            $utilisateur1->addPlateau($plateau);
            $utilisateur1->addPlateauEnJeux($plateauEnJeu);

            $manager->persist($utilisateur1);

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
          
          
          foreach($plateau->getCases() as $uneCase)
          {
            $cases= new Cases();
            $cases->setDescriptifDefi($uneCase->getDescriptifDefi());
            $cases->setConsignes($uneCase->getConsignes());
            $cases->setCodeValidation($uneCase->getCodeValidation());
            $cases->setPlateauEnJeu($plateauEnJeu);
            $manager->persist($cases);

            foreach($uneCase->getRessources() as $uneRessource)
            {
                $ressource = new Ressource();
                $ressource->setChemin($uneRessource->getChemin());
                $ressource->setCases($cases);
                $cases->addRessource($ressource);
                $manager->persist($cases);
                $manager->persist($ressource);
            }
            
           
            
            
          }
          $manager->persist($plateauEnJeu);
              
          // Enregistrer la ressource en base de données
          
          $manager->flush();

          // Rediriger l'utilisateur vers la page d'accueil
          return $this->redirectToRoute('espace_partie');
          echo "ca marche";
       }
        return $this->render('les_rois_du/creationpartie.html.twig', ['vueFormulaireCreationPartie'=>$formulairePartie->createview(),
        ]);
    }

    /**
     * @Route("/parties/{idPartie}", name="partie_en_cours")
     */
    public function affichagePartieEnCours($idPartie)
    {
        $repositoryPartie=$this->getDoctrine()->getRepository(Partie::class);
        $partie = $repositoryPartie->find($idPartie);
        $parties = $repositoryPartie->findAll();
        return $this->render('les_rois_du/partieencours.html.twig',['partie'=>$partie, 'parties'=>$parties]);
    }

    /**
     * @Route("/parties/{idPartie}/parametres", name="parametres_partie")
     */
    public function affichageParametresPartie($idPartie)
    {
        $repositoryPartie=$this->getDoctrine()->getRepository(Partie::class);
        $partie = $repositoryPartie->find($idPartie);
        return $this->render('les_rois_du/parametrespartie.html.twig',['partie'=>$partie]);
    }

    /**
     * @Route("/plateaux/{idPlateau}", name="plateau")
     */
    public function affichagePlateau($idPlateau)
    {
        $repositoryPlateau=$this->getDoctrine()->getRepository(Plateau::class);
        $plateau = $repositoryPlateau->find($idPlateau);
        $plateaux = $repositoryPlateau->findAll();
        return $this->render('les_rois_du/plateau.html.twig',['plateau'=>$plateau, 'plateaux'=>$plateaux]);
    }

    /**
     * @Route("/plateaux/{idPlateau}/parametres", name="parametres_plateau")
     */
    public function affichageParametresPlateau($idPlateau)
    {
        $repositoryPlateau=$this->getDoctrine()->getRepository(Plateau::class);
        $plateau = $repositoryPlateau->find($idPlateau);
        return $this->render('les_rois_du/parametresplateau.html.twig',['plateau'=>$plateau]);
    }

    /**
     * @Route("/case{idCase}_{numCase}", name="consultation_case")
     */
    public function affichageCase($idCase,$numCase)
    {
        $repositoryCases=$this->getDoctrine()->getRepository(Cases::class);
        $cases = $repositoryCases->find($idCase);
        return $this->render('les_rois_du/consultationcase.html.twig',['case'=>$cases, 'numCase'=>$numCase]);
    }



}
