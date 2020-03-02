<?php

namespace App\Controller;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Form\UtilisateurType;
use App\Form\PartieType;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use App\Security\LoginAuthenticator;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class LesRoisDuController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/", name="accueil")
     */
    public function index()
    {
        return $this->render('les_rois_du/index.html.twig');
    }
    
    /**
     * @Route("/inscription", name="page_inscription")
     */
    public function affichagePageInscription(Request $request, ObjectManager $manager)
    {
        // Création d'une entrprise vierge
        $utilisateur=new Utilisateur();

        // Création de l'objet formulaire
        $formulaireUtilisateur=$this->createForm(UtilisateurType::class, $utilisateur);
      
        $formulaireUtilisateur->handleRequest($request);

        if ($formulaireUtilisateur->isSubmitted() && $formulaireUtilisateur->isValid())
        {        
           
            $utilisateur->setAvatar("https://nsa40.casimages.com/img/2020/02/20/200220051454807035.jpg");
            // l'utilisateur a le role USER
            $roles[] =  'ROLE_USER';
            $utilisateur->setRoles($roles);
            // l'utilisateur cree un compte il n'est donc pas invité
            $utilisateur->setEstInvite(false);

            $plainPassword = $utilisateur->getPlainPassword();
            $utilisateur->setMotDePasse($this->passwordEncoder->encodePassword(
                $utilisateur,
                $plainPassword
             ));
           
            // Enregistrer la ressource en base de données
           $manager->persist($utilisateur);
           $manager->flush();

           // Rediriger l'utilisateur vers la page d'accueil
           return $this->redirectToRoute('app_login');
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
    public function affichageEspacePartie(UserInterface $user)
    {
        $repositoryUtilisateur=$this->getDoctrine()->getRepository(Utilisateur::class);
        $userId = $user->getId();
        $user = $repositoryUtilisateur->find($userId);

        $cree = $user->getPartiesCree();

        $rejoins = $user->getPartiesRejoins();

        return $this->render('les_rois_du/espacepartie.html.twig', ['partiesCree'=>$cree, 'partiesRejoins'=>$rejoins]);
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
    public function affichageEspaceCompte(UserInterface $user)
    {
        
        $repositoryUtilisateur=$this->getDoctrine()->getRepository(Utilisateur::class);
        $userId = $user->getId();
        $user = $repositoryUtilisateur->find($userId);
        return $this->render('les_rois_du/espacecompte.html.twig', ['utilisateur'=>$user]);
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
    public function affichageCreationPartie(Request $request, ObjectManager $manager, UserInterface $user)
    {
        
        $repositoryUtilisateur=$this->getDoctrine()->getRepository(Utilisateur::class);
        $userId = $user->getId();
        $createur = $repositoryUtilisateur->find($userId);
       // Création d'une entrprise vierge
       $partie=new Partie();

       // Création de l'objet formulaire
       $formulairePartie=$this->createForm(PartieType::class, $partie);

       $formulairePartie->handleRequest($request);

       if ($formulairePartie->isSubmitted())
       { 
      
        $plateau = $partie->getPlateau();

        $plateauEnJeu = new PlateauEnJeu();
        $plateauEnJeu->setNom($plateau->getNom());
        $plateauEnJeu->setDescription($plateau->getDescription());
        $plateauEnJeu->setNiveauDifficulte($plateau->getNiveauDifficulte());
        $plateauEnJeu->setNbCases($plateau->getNbCases());


        $partie->setPlateauDeJeu($plateauEnJeu);
        $partie->setCreateur($createur);

        $code = strtoupper(substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 5, 5));
        $partie->setCode($code);

        $partie->setEstLance(false);

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
                ->setNumero($uneCase->getNumero())
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
     * @Route("/supression/partie{idPartie}", name="supprimer_partie")
     */
    public function supprimerUnePartie($idPartie)
    {
 
        $entityManager = $this->getDoctrine()->getManager();
        $repositoryPartie=$entityManager->getRepository(Partie::class);

        $partie = $repositoryPartie->find($idPartie);

        $plateauEnJeu = $partie->getPlateauDeJeu();

        $tabCase = $plateauEnJeu->getCases();
        foreach($tabCase as $uneCase){
            
            $tabRessource = $uneCase->getRessources();
            foreach($tabRessource as $uneRessource){
             
                $entityManager->remove($uneRessource);
                
            }

            $entityManager->remove($uneCase);
        }

        $tabPion = $plateauEnJeu->getPions();
        foreach($tabPion as $unePion){

            $entityManager->remove($unePion);
        }

        $entityManager->remove($plateauEnJeu);
        
        $entityManager->remove($partie);

        $entityManager->flush();

    return $this->redirectToRoute('espace_partie');

    }

    /**
     * @Route("/invite", name="en_invite")
     */
    public function connexionInvite(ObjectManager $manager, Request $request, GuardAuthenticatorHandler $guardHandler, LoginAuthenticator $authenticator)
    {

        $invite = new Utilisateur();

        $random = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 5, 5);

        $fakeEmail = $random."@guest.com";
        $invite->setEmail($fakeEmail);

        $fakePseudo = "Guest".$random;

        $invite->setPseudo($fakePseudo);

        $invite->setAvatar("https://nsa40.casimages.com/img/2020/02/20/200220051454807035.jpg");

        $roles[] =  'ROLE_USER';
        $invite->setRoles($roles);

        $invite->setEstInvite(true);

        $plainPassword = $random;
        $invite->setMotDePasse($this->passwordEncoder->encodePassword(
            $invite,
            $plainPassword
         ));
           
        // Enregistrer la ressource en base de données
        $manager->persist($invite);
        $manager->flush();

        return $guardHandler->authenticateUserAndHandleSuccess(
                $invite,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
    }

    /**
     * @Route("/join{code}", name="join_partie")
     */
    public function joinPartie(ObjectManager $manager, UserInterface $user, $code)
    {

        $repositoryUtilisateur=$this->getDoctrine()->getRepository(Utilisateur::class);
        $userId = $user->getId();
        $joueur = $repositoryUtilisateur->find($userId);

        $entityManager = $this->getDoctrine()->getManager();
        $repositoryPartie=$entityManager->getRepository(Partie::class);
        $partie = $repositoryPartie->findOneBy(['code' => $code]);

        $joueur->addPartiesRejoin($partie);
           
        // Enregistrer la ressource en base de données
        $manager->persist($partie);
        $manager->persist($joueur);
        $manager->flush();

        return $this->redirectToRoute('espace_partie');
    }


    /**
     * @Route("/api/plateaux/{idPlateau}/{numCase}", name="api_cases")
     */
    public function apiCases($idPlateau, $numCase)
    {

        $repositoryCases=$this->getDoctrine()->getRepository(Cases::class);
        $case = $repositoryCases->findOneBy(['plateau' => $idPlateau, 'numero' => $numCase]);

        $numero = $case->getNumero();
        $defi = $case->getDescriptifDefi();
        $consignes = $case->getConsignes();
        $code = $case->getCodeValidation();

        return $this->json(['numero' => $numero, 'defi' => $defi, 'consignes' => $consignes, 'code' => $code]);
    }

    /**
     * @Route("/api/plateaux/{idPlateau}", name="api_plateaux")
     */
    public function apiPlateauxCases($idPlateau)
    {

        $repositoryPlateau=$this->getDoctrine()->getRepository(Plateau::class);
        $plateau = $repositoryPlateau->find($idPlateau);

        $nom = $plateau->getNom();
        $description = $plateau->getDescription();
        $difficulte = $plateau->getNiveauDifficulte();
        $nbCases = $plateau->getNbCases();

        return $this->json(['nom' => $nom, 'description' => $description, 'difficulte' => $difficulte, 'nbCases' => $nbCases]);
    }



}
