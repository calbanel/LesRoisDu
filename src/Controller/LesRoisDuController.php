<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
    public function affichagePageInscription()
    {
        return $this->render('les_rois_du/inscription.html.twig');
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
        return $this->render('les_rois_du/espacepartie.html.twig');
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
        return $this->render('les_rois_du/espaceplateau.html.twig');
    }

    /**
     * @Route("/parties/creation", name="creation_partie")
     */
    public function affichageCreationPartie()
    {
        return $this->render('les_rois_du/creationPartie.html.twig');
    }

    /**
     * @Route("/parties/{idPartie}", name="partie_en_cours")
     */
    public function affichagePartieEnCours($idPartie)
    {
        return $this->render('les_rois_du/partieencours.html.twig');
    }

    /**
     * @Route("/parties/{idPartie}/parametres", name="parametres_partie")
     */
    public function affichageParametresPartie($idPartie)
    {
        return $this->render('les_rois_du/parametrespartie.html.twig');
    }

    /**
     * @Route("/plateaux/{idPlateau}", name="plateau")
     */
    public function affichagePlateau($idPlateau)
    {
        return $this->render('les_rois_du/plateau.html.twig');
    }

    /**
     * @Route("/plateaux/{idPlateau}/parametres", name="parametres_plateau")
     */
    public function affichageParametresPlateau($idPlateau)
    {
        return $this->render('les_rois_du/parametresplateau.html.twig');
    }



}
