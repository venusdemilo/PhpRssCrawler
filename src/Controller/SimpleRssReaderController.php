<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use SimplePie;
use Symfony\Component\HttpFoundation\JsonResponse;

class SimpleRssReaderController extends AbstractController
{
    /**
     * @Route("/simple/rss/reader", name="simple_rss_reader")
     */
    public function index()
    {
      $urlFeed = 'https://www.lemonde.fr/rss/une.xml';
      $feed = new SimplePie();
      $feed->set_cache_location('/home/philippe/SimplePieCache');
      $feed->set_feed_url($urlFeed);
      $feed->init();
      $feed->handle_content_type();
      if ($feed->error())
      {
        echo 'error !';
      }
      foreach ($feed->get_items() as $item)
      {
        $arr[] = $item->get_title();

      }
      $arr = json_encode($arr,JSON_FORCE_OBJECT);
      var_dump($arr);
        /*
        return $this->render('simple_rss_reader/index.html.twig', [
            'controller_name' => 'SimpleRssReaderController',
        ]);
        */

        $response = new JsonResponse();

    $response->setData($arr);
 return $response;
    }
}
