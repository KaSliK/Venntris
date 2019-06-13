<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AboutSiteController extends AbstractController
{
    /**
     * @Route("/about", name="app_about_site")
     */
    public function index()
    {
        return $this->render('about_site/index.html.twig', [
            'controller_name' => 'AboutSiteController',
        ]);
    }
}
