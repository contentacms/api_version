<?php

namespace Drupal\api_version\EventSubscriber;

use Drupal\api_version\ApiVersionCalculator;
use Drupal\Core\Config\ConfigCrudEvent;
use Drupal\Core\Config\ConfigEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ConfigEventSubscriber implements EventSubscriberInterface {

  /**
   * @var \Drupal\api_version\ApiVersionCalculator
   */
  private $apiVersionCalculator;

  /**
   * ConfigEventSubscriber constructor.
   * @param \Drupal\api_version\ApiVersionCalculator $apiVersionCalculator
   */
  public function __construct(ApiVersionCalculator $apiVersionCalculator) {
    $this->apiVersionCalculator = $apiVersionCalculator;
  }

  public function onSave(ConfigCrudEvent $event) {
    $this->apiVersionCalculator->updateApiVersion($event->getConfig());
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[ConfigEvents::SAVE][] = 'onSave';
    return $events;
  }

}
