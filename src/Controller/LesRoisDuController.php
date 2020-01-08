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
     * @Route("/game", name="page_principale")
     */
    public function affichagePageJeu()
    {
        return $this->render('les_rois_du/index.html.twig');
    }
    
    /**
     * @Route("/createur", name="page_createur")
     */
    public function affichagePageCreateur()
    {
        return $this->render('les_rois_du/index.html.twig');
    }

    /**
     * @Route("/createur/plateaux", name="page_plateaux")
     */
    public function affichagePagePlateaux()
    {
        return $this->render('les_rois_du/index.html.twig');
    }

    /**
     * @Route("/createur/partie", name="page_partie")
     */
    public function affichagePagePartie()
    {
        return $this->render('les_rois_du/index.html.twig');
    }

    /**
     * @Route("/createur/historique", name="page_historique")
     */
    public function affichagePageHistorique()
    {
        return $this->render('les_rois_du/index.html.twig');
    }

 
    /**
     * @Route("/createur/partager", name="page_patager")
     */
    public function affichagePagePartager()
    {
        return $this->render('les_rois_du/index.html.twig');
    }



}
