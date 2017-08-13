<?php

namespace Drupal\api_version\EventSubscriber;

use Drupal\api_version\ApiVersionCalculator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ResponseEventSubscriber implements EventSubscriberInterface {

  /**
   * @var \Drupal\api_version\ApiVersionCalculator
   */
  private $apiVersionCalculator;

  /**
   * ResponseEventSubscriber constructor.
   * @param \Drupal\api_version\ApiVersionCalculator $apiVersionCalculator
   */
  public function __construct(ApiVersionCalculator $apiVersionCalculator) {
    $this->apiVersionCalculator = $apiVersionCalculator;
  }

  public function onResponse(FilterResponseEvent $event) {
    $event->getResponse()->headers->set('X-Drupal-ApiVersion', $this->apiVersionCalculator->getApiVersion()->toSemanticString());
  }

  public static function getSubscribedEvents() {
    $events[KernelEvents::RESPONSE] = 'onResponse';
    return $events;
  }

}
