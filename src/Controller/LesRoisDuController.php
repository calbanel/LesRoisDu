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
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class LesRoisDuController extends AbstractController
{
    private $passwordEncoder;
    private $lien;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->lien = "http://iparla.iutbayonne.univ-pau.fr:8001";
    }

    /**
     * @Route("/", name="accueil")
     */
    public function index()
    {
        return $this->render('les_rois_du/index.html.twig');
    }
    
     /**
     * @Route("/credits", name="credits")
     */
    public function afiichageCredits()
    {
        return $this->render('les_rois_du/credits.html.twig');
    }

    /**
     * @Route("/inscription", name="page_inscription")
     */
    public function affichagePageInscription(Request $request, ObjectManager $manager, GuardAuthenticatorHandler $guardHandler, LoginAuthenticator $authenticator)
    {
        // Création d'un utilisateur vierge
        $utilisateur=new Utilisateur();

        // Création de l'objet formulaire
        $formulaireUtilisateur=$this->createForm(UtilisateurType::class, $utilisateur);
      
        $formulaireUtilisateur->handleRequest($request);

        if ($formulaireUtilisateur->isSubmitted() && $formulaireUtilisateur->isValid())
        {        
           
            $utilisateur->setAvatar("/img/avatar8.jpg");
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

            $repositoryPlateau=$this->getDoctrine()->getRepository(Plateau::class);
            $plateau = $repositoryPlateau->find(7);

            $utilisateur->addPlateau($plateau);

            $plateau2 = $repositoryPlateau->find(6);

            $utilisateur->addPlateau($plateau2);
           
            // Enregistrer la ressource en base de données
           $manager->persist($utilisateur);
           $manager->flush();

           // Rediriger l'utilisateur vers la page d'accueil
           return $guardHandler->authenticateUserAndHandleSuccess(
                $utilisateur,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }
        
        
        
        
        return $this->render('les_rois_du/inscription.html.twig',['vueFormulaireInscription' => $formulaireUtilisateur->createView()]);
    }

    /**
     * @Route("/hub", name="hub")
     */
    public function affichageHub(UserInterface $user)
    {
        $repositoryUtilisateur=$this->getDoctrine()->getRepository(Utilisateur::class);
        $userId = $user->getId();
        $user = $repositoryUtilisateur->find($userId);

        return $this->render('les_rois_du/hub.html.twig', ['utilisateur'=>$user]);
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

        return $this->render('les_rois_du/espacepartie.html.twig', ['partiesCree'=>$cree, 'partiesRejoins'=>$rejoins, 'utilisateur'=>$user]);
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
    public function affichageEspacePlateau(UserInterface $user)
    {
        $repositoryUtilisateur=$this->getDoctrine()->getRepository(Utilisateur::class);
        $userId = $user->getId();
        $user = $repositoryUtilisateur->find($userId);
        $repositoryPlateaux=$this->getDoctrine()->getRepository(Plateau::class);
        $plateaux = $repositoryPlateaux->findAll();
        
        return $this->render('les_rois_du/espaceplateau.html.twig', ['plateaux'=>$plateaux, 'utilisateur'=>$user]);
    }

    /**
     * @Route("/creation/parties", name="creation_partie")
     */
    public function affichageCreationPartie(Request $request, ObjectManager $manager, UserInterface $user)
    {
        
        $repositoryUtilisateur=$this->getDoctrine()->getRepository(Utilisateur::class);
        $userId = $user->getId();
        $createur = $repositoryUtilisateur->find($userId);
       // Création d'une entreprise vierge
       $partie=new Partie();

       // Création de l'objet formulaire

       $formulairePartie = $this->createForm(PartieType::class, $partie);

       $formulairePartie->handleRequest($request);

       if ($formulairePartie->isSubmitted() && $formulairePartie->isValid())
       { 
      
        $plateau = $partie->getPlateau();

        $plateauEnJeu = new PlateauEnJeu();
        $plateauEnJeu->setNom($plateau->getNom());
        $plateauEnJeu->setDescription($plateau->getDescription());
        $plateauEnJeu->setNiveauDifficulte($plateau->getNiveauDifficulte());
        $plateauEnJeu->setNbCases($plateau->getNbCases());

        $pions1 = new Pion();
        $pions1->setNom("rouge");
        $pions1->setCouleur("red");
        $pions1->setAvancementPlateau(0);
        $pions1->setPlateauEnJeu($plateauEnJeu);

        $manager->persist($pions1);

        $pions2 = new Pion();
        $pions2->setNom("vert");
        $pions2->setCouleur("green");
        $pions2->setAvancementPlateau(0);
        $pions2->setPlateauEnJeu($plateauEnJeu);

        $manager->persist($pions2);

        $pions3 = new Pion();
        $pions3->setNom("bleu");
        $pions3->setCouleur("blue");
        $pions3->setAvancementPlateau(0);
        $pions3->setPlateauEnJeu($plateauEnJeu);

        $manager->persist($pions3);

        $pions4 = new Pion();
        $pions4->setNom("jaune");
        $pions4->setCouleur("yellow");
        $pions4->setAvancementPlateau(0);
        $pions4->setPlateauEnJeu($plateauEnJeu);

        $manager->persist($pions4);


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
     * @Route("/parties/join{code}", name="join_partie")
     */
    public function joinPartie(ObjectManager $manager, UserInterface $user, $code)
    {

        $repositoryUtilisateur=$this->getDoctrine()->getRepository(Utilisateur::class);
        $userId = $user->getId();
        $joueur = $repositoryUtilisateur->find($userId);

        $entityManager = $this->getDoctrine()->getManager();
        $repositoryPartie=$entityManager->getRepository(Partie::class);
        $partie = $repositoryPartie->findOneBy(['code' => $code]);

        

        if(!is_null($partie)){  
            $plateauDeJeu = $partie->getPlateauDeJeu();          
            if($partie->getJoueurs()->isEmpty()){

            $joueur->addPartiesRejoin($partie);
            $joueur->addPlateauEnJeux($partie->getPlateauDeJeu());

            $plateauDeJeu->setJoueur($joueur);
            
            // Enregistrer la ressource en base de données
            $manager->persist($plateauDeJeu);
            $manager->persist($partie);
            $manager->persist($joueur);
            $manager->flush();
            }
        }

        return $this->redirectToRoute('espace_partie');
    }


    /**
     * @Route("/parties/{idPartie}", name="partie_en_cours")
     */
    public function affichagePartieEnCours($idPartie, UserInterface $user)
    {

        
        $repositoryPartie=$this->getDoctrine()->getRepository(Partie::class);
        $partie = $repositoryPartie->find($idPartie);
        $parties = $repositoryPartie->findAll();

        $repositoryUtilisateur=$this->getDoctrine()->getRepository(Utilisateur::class);
        $userId = $user->getId();
        $user = $repositoryUtilisateur->find($userId);

        $cree = $user->getPartiesCree();

        $rejoins = $user->getPartiesRejoins();

        $trouve = false;

        foreach($cree as $unePartie){
            if($unePartie->getId() == $partie->getId()){
                $trouve = true;
            }
        }

        foreach($rejoins as $unePartie){
            if($unePartie->getId() == $partie->getId()){
                $trouve = true;
            }
        }

        if ($trouve == true)
        {        
        return $this->render('les_rois_du/partieencours.html.twig',['partie'=>$partie,'partiesCree'=>$cree, 'partiesRejoins'=>$rejoins, 'utilisateur'=>$user]);
        }
        else
        {
            return $this->redirectToRoute('espace_partie');
        }
    }

    /**
     * @Route("/parametres/parties/{idPartie}", name="parametres_partie")
     */
    public function affichageParametresPartie($idPartie, UserInterface $user)
    {
        $repositoryUtilisateur=$this->getDoctrine()->getRepository(Utilisateur::class);
        $userId = $user->getId();
        $utilisateur = $repositoryUtilisateur->find($userId);

        $repositoryPartie=$this->getDoctrine()->getRepository(Partie::class);
        $partie = $repositoryPartie->find($idPartie);

        if ($partie->getCreateur()->getPseudo() == $utilisateur->getPseudo()){

        return $this->render('les_rois_du/parametrespartie.html.twig',['partie'=>$partie]);

        }
        else
        {
            return $this->redirectToRoute('espace_partie');
        }

        
    }

    /**
     * @Route("/plateaux/{idPlateau}", name="plateau")
     */
    public function affichagePlateau($idPlateau, UserInterface $user)
    {
        $repositoryUtilisateur=$this->getDoctrine()->getRepository(Utilisateur::class);
        $userId = $user->getId();
        $user = $repositoryUtilisateur->find($userId);

        $repositoryPlateau=$this->getDoctrine()->getRepository(Plateau::class);
        $plateau = $repositoryPlateau->find($idPlateau);

        return $this->render('les_rois_du/plateau.html.twig',['plateau'=>$plateau, 'utilisateur'=>$user]);
    }

    /**
     * @Route("/parametres/plateaux/{idPlateau}", name="parametres_plateau")
     */
    public function affichageParametresPlateau($idPlateau)
    {

        $repositoryPlateau=$this->getDoctrine()->getRepository(Plateau::class);
        $plateau = $repositoryPlateau->find($idPlateau);
        return $this->render('les_rois_du/parametresplateau.html.twig',['plateau'=>$plateau]);
    }

    /**
     * @Route("/supression/parties/{idPartie}", name="supprimer_partie")
     */
    public function supprimerUnePartie($idPartie, UserInterface $user)
    {
        $repositoryUtilisateur=$this->getDoctrine()->getRepository(Utilisateur::class);
        $userId = $user->getId();
        $utilisateur = $repositoryUtilisateur->find($userId);

        $repositoryPartie=$this->getDoctrine()->getRepository(Partie::class);
        $partie = $repositoryPartie->find($idPartie);

        if ($partie->getCreateur()->getPseudo() == $utilisateur->getPseudo()){

        

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
    }

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

        $fakePseudo = "Guest_".$random;

        $invite->setPseudo($fakePseudo);

        $invite->setAvatar("/img/avatarGuest.jpg");

        $roles[] =  'ROLE_INVITE';
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
     * @Route("/compte/changement{code}", name="changement_avatar")
     */
    public function changementAvatar(ObjectManager $manager, UserInterface $user, $code)
    {

        $repositoryUtilisateur=$this->getDoctrine()->getRepository(Utilisateur::class);
        $userId = $user->getId();
        $utilisateur = $repositoryUtilisateur->find($userId);

        $avatar = "/img/avatar" . $code . ".jpg";

        $utilisateur->setAvatar($avatar);

        $manager->persist($utilisateur);
        $manager->flush();

        return $this->redirectToRoute('espace_compte');
    }




    /**
     * @Route("/api/plateaux/{idPlateau}", name="api_plateaux")
     */
    public function apiPlateaux($idPlateau)
    {

        $repositoryPlateau=$this->getDoctrine()->getRepository(Plateau::class);
        $plateau = $repositoryPlateau->find($idPlateau);

        $nom = $plateau->getNom();
        $description = $plateau->getDescription();
        $difficulte = $plateau->getNiveauDifficulte();
        $nbCases = $plateau->getNbCases();

        return $this->json(['nom' => $nom, 'description' => $description, 'difficulte' => $difficulte, 'nbCases' => $nbCases]);
    }

    /**
     * @Route("/api/plateauEnJeu/{idPlateauEnJeu}", name="api_plateaudejeu")
     */
    public function apiPlateauEnJeu($idPlateauEnJeu)
    {

        $repositoryPlateauEnJeu=$this->getDoctrine()->getRepository(PlateauEnJeu::class);
        $plateau = $repositoryPlateauEnJeu->find($idPlateauEnJeu);

        $nom = $plateau->getNom();
        $description = $plateau->getDescription();
        $difficulte = $plateau->getNiveauDifficulte();
        $nbCases = $plateau->getNbCases();

        if (is_null($plateau->getJoueur())){
            $joueur = "";
        }
        else
        {
            $joueur = $plateau->getJoueur()->getPseudo();
        }

        $pions = $plateau->getPions();
        $arrayInfoPions = [];

        foreach ($pions as $unPion) {
            $nom= $unPion->getNom();
            $couleur= $unPion->getCouleur();
            $position= $unPion->getAvancementPlateau();
            array_push($arrayInfoPions, ['nom' => $nom, 'couleur' => $couleur, 'position' => $position]);       
        }

        $partie = $this->lien."/api/partie/".$plateau->getPartie()->getId();

        return $this->json(['nom' => $nom, 'description' => $description, 'difficulte' => $difficulte, 'nbCases' => $nbCases, 'joueur' => $joueur, 'partie' => $partie,'pions' => $arrayInfoPions]);
    }

    /**
     * @Route("/api/plateaux/{idPlateau}/cases", name="api_cases_plateau")
     */
    public function apiToutesCasesPlateau($idPlateau)
    {

        $repositoryPlateau=$this->getDoctrine()->getRepository(Plateau::class);
        $plateau = $repositoryPlateau->find($idPlateau);

        $caseData = [];

        $tabCase = $plateau->getCases();

        foreach($tabCase as $uneCase){

            $ressourceData = [];
            
            $numero = $uneCase->getNumero();
            $defi = $uneCase->getDescriptifDefi();
            $consignes = $uneCase->getConsignes();
            $code = $uneCase->getCodeValidation();

            $tabRessource = $uneCase->getRessources();
            foreach($tabRessource as $uneRessource){

                $chemin = $uneRessource->getChemin();
                $infosR = ['chemin' => $chemin];

                array_push($ressourceData, $infosR);
                
            }

            

            $infos = ['numero' => $numero, 'defi' => $defi, 'consignes' => $consignes, 'code' => $code, 'ressources' => $ressourceData];

            array_push($caseData, $infos);
        }

        $data = ['cases' => $caseData];

        return $this->json($data);
    }

    /**
     * @Route("/api/plateauEnJeu/{idPlateauEnJeu}/cases", name="api_cases_plateauenjeu")
     */
    public function apiToutesCasesPlateauEnJeu($idPlateauEnJeu)
    {

        $repositoryPlateauEnJeu=$this->getDoctrine()->getRepository(PlateauEnJeu::class);
        $plateau = $repositoryPlateauEnJeu->find($idPlateauEnJeu);

        $caseData = [];

        $tabCase = $plateau->getCases();

        foreach($tabCase as $uneCase){

            $ressourceData = [];
            
            $numero = $uneCase->getNumero();
            $defi = $uneCase->getDescriptifDefi();
            $consignes = $uneCase->getConsignes();
            $code = $uneCase->getCodeValidation();

            $tabRessource = $uneCase->getRessources();
            foreach($tabRessource as $uneRessource){

                $chemin = $uneRessource->getChemin();
                $infosR = ['chemin' => $chemin];

                array_push($ressourceData, $infosR);
                
            }

            

            $infos = ['numero' => $numero, 'defi' => $defi, 'consignes' => $consignes, 'code' => $code, 'ressources' => $ressourceData];

            array_push($caseData, $infos);
        }

        $data = ['cases' => $caseData];

        return $this->json($data);
    }

    /**
     * @Route("/api/partie/{idPartie}", name="api_parties")
     */
    public function apiPartie($idPartie)
    {

        $repositoryPartie=$this->getDoctrine()->getRepository(Partie::class);
        $partie = $repositoryPartie->find($idPartie);

        $nom = $partie->getNom();
        $description = $partie->getDescription();
        $createur = $partie->getCreateur()->getPseudo();
        if ($partie->getJoueurs()->isEmpty()){
            $joueur = "";
        }
        else
        {
            $joueur = $partie->getJoueurs()->get(0)->getPseudo();
        }
        $estLance = $partie->getEstLance();

        $plateauDeJeu = $this->lien."/api/plateauEnJeu/".$partie->getPlateauDeJeu()->getId();

        return $this->json(['nom' => $nom, 'description' => $description, 'createur' => $createur, 'joueur' => $joueur, 'estLance' => $estLance, 'plateau_de_jeu' => $plateauDeJeu]);
    }

 
}
