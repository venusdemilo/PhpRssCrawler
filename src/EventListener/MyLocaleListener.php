<?php
namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class MyLocaleListener
{
      public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        // some logic to determine the $locale
        $request->setLocale($request->attributes->get('_locale'));
    }

}
