<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use SimplePie;

class JqueryController extends AbstractController
{
    /**
     * @Route("/jquery", name="jquery")
     */
    public function index()
    {

   //if ($feed->error())

        return $this->render('jquery/index.html.twig', [
            'controller_name' => 'JqueryController',
        ]);
    }
}
