<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LesRoisDuController extends AbstractController
{
    /**
     * @Route("/les/rois/du", name="les_rois_du")
     */
    public function index()
    {
        return $this->render('les_rois_du/index.html.twig', [
            'controller_name' => 'LesRoisDuController',
        ]);
    }
}
