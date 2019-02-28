<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use SimplePie;
use Symfony\Component\HttpFoundation\JsonResponse;

class SimpleRssReaderController extends AbstractController
{
    /**
     * @Route("/simple/rss/reader/{urlid}", name="simple_rss_reader")
     */
    public function index($urlId)
    {
      sleep(2);
      $urlFeed = urldecode($urlid);
      $feed = new SimplePie();
      $feed->set_cache_location('/Users/philippe/simplepie');
      $feed->set_feed_url($urlFeed);
      $feed->init();
      $feed->handle_content_type();
      if ($feed->error())
      {
        $arr[] = ['error' => true];
      }
      foreach ($feed->get_items() as $item)
      {
        $arr[] = ['title' => $item->get_title(),'link'=>$item->get_link()];

      }
      //$arr = json_encode($arr,JSON_FORCE_OBJECT);
    //  print_r($arr);
    //  echo "----------------------------------------------------------";
        /*
        return $this->render('simple_rss_reader/index.html.twig', [
            'controller_name' => 'SimpleRssReaderController',
        ]);
        */

        $response = new JsonResponse(['data' => $arr]);
        return $response;
    }
}
