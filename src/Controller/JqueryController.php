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
      $urlFeed = 'https://www.lemonde.fr/rss/une.xml';
      $feed = new SimplePie();
   $feed->set_cache_location('/home/philippe/SimplePieCache');
   $feed->set_feed_url($urlFeed);
   $feed->init();
   $feed->handle_content_type();
   //if ($feed->error())

        return $this->render('jquery/index.html.twig', [
            'controller_name' => 'JqueryController',
        ]);
    }
}
