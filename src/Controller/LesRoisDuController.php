<?php

namespace App\Controller;

use Doctrine\Common\Persistence\ObjectManager;
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
<<<<<<< HEAD
=======
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
>>>>>>> creation_partie
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
        $this->addFlash('success',"misere"); 
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
        
        $repositoryUtilisateur=$this->getDoctrine()->getRepository(Utilisateur::class);
        $createur = $repositoryUtilisateur->find(7);
       // Création d'une entrprise vierge
       $partie=new Partie();

       // Création de l'objet formulaire
       $formulairePartie=$this->createFormBuilder($partie)
       ->add('Nom',TextType::class)
       ->add('Description',TextareaType::class)
       ->add('nbPlateaux',IntegerType::class,['data' => '1', 'attr'=> ['readonly'=> true ]])
       ->add('nbPionParPlateau',IntegerType::class,['data' => '1', 'attr'=> ['readonly'=> true ]])
       ->add('nbFacesDe',IntegerType::class,['data' => '4', 'attr'=> ['readonly'=> true ]])
      ->add('plateau', EntityType::class, ['class' => Plateau::class,
                                                'choice_label' => 'nom',
                                                'multiple' => false,
                                                'expanded' => false])
       ->getForm();

       $formulairePartie->handleRequest($request);

       if ($formulairePartie->isSubmitted())
       { 
   
        try {    
        $plateau = $partie->getPlateau();

        $plateauEnJeu = new PlateauEnJeu();
        $plateauEnJeu->setNom($plateau->getNom());
        $plateauEnJeu->setDescription($plateau->getDescription());
        $plateauEnJeu->setNiveauDifficulte($plateau->getNiveauDifficulte());


        $partie->setPlateauDeJeu($plateauEnJeu);
        $partie->setCreateur($createur);

        $code = strtoupper(substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 5, 5));
        $partie->setCode($code);

        $createur->addPartiesCree($partie);

        $manager->persist($partie);

        $plateauEnJeu->setPartie($partie);

        $manager->persist($createur);
        
        $tabCase = $plateau->getCases();
        foreach($tabCase as $uneCase){
            $cases = new Cases();
            $cases->setDescriptifDefi($uneCase->getDescriptifDefi())
                ->setConsignes($uneCase->getConsignes())
                ->setCodeValidation($uneCase->getCodeValidation())
            ;

            $cases->setPlateauEnJeu($plateauEnJeu);
            
            $manager->persist($cases);

            $tabRessource = $uneCase->getRessources();
            foreach($tabRessource as $uneRessource){
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
          $this->addFlash('success',"Add done!");
        } catch (DBALException $e) {
            $this->addFlash('success',"Add not done: " . $e->getMessage());
        return $this->redirectToRoute('espace_partie');
        }
     catch (\Exception $e) {
        $this->addFlash('success',"Add not done: " . $e->getMessage());
        return $this->redirectToRoute('espace_partie');
    }

          // Rediriger l'utilisateur vers la page d'accueil
          return $this->redirectToRoute('espace_partie');
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

    /**
     * @Route("/parties", name="supprimer_partie")
     */
    public function supprimerUnePartie($idPartie)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repositoryPartie=$entityManager->getRepository(Partie::class);

        $partieSupp = $repositoryPartie->find($idPartie);

        $joueurs = $partieSupp->getJoueurs();

       // $partieSupp->getPlateau()->removeParty($partieSupp);

        $joueurs[0]->removePartiesRejoin($partieSupp);

        $joueurs[0]->removePlateauEnJeux($partieSupp->getPlateauEnJeux());

        $partieSupp->getCreateur()->removePartiesCree($partieSupp);

        $entityManager->remove($partieSupp);

        $entityManager->flush();

        $parties = $repositoryPartie->findAll();
        
        return $this->render('les_rois_du/espacepartie.html.twig', ['parties'=>$parties]);
    }

}
