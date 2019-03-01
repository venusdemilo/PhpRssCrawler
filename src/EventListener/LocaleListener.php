<?php
namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class LocaleListener
{
      public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        // some logic to determine the $locale
        $request->setLocale('en');
    }

}
