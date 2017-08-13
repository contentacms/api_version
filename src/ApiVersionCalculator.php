<?php

namespace Drupal\api_version;

use Drupal\Core\Config\Config;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\State\StateInterface;

class ApiVersionCalculator {

  /**
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  /**
   * ApiVersionCalculator constructor.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   * @param \Drupal\Core\State\StateInterface $state
   */
  public function __construct(ConfigFactoryInterface $configFactory, StateInterface $state) {
    $this->configFactory = $configFactory;
    $this->state = $state;
  }

  /**
   * @return string|null
   */
  protected function getLastConfigHash() {
    return $this->state->get('api_version.last_config_hash');
  }

  /**
   * @return \Drupal\api_version\VersionNumber|null
   */
  protected function getLastVersionNumber() {
    return $this->state->get('api_version.last_version_number');
  }

  /**
   * @return \Drupal\api_version\VersionNumber
   */
  public function getApiVersion() {
    $last_version_number = $this->getLastVersionNumber();
    if ($last_version_number === NULL) {
      $last_version_number = new VersionNumber(1);
      $this->state->set('api_version.last_version_number', $last_version_number);
    }

    return $last_version_number;
  }

  public function updateApiVersion(Config $config) {
    $api_version = $this->getApiVersion();
    // @todo In a potential future world we would detect minor/patch API version
    // changes here.
    $next_api_version = $api_version->increaseMajorVersion();
    $this->state->set('api_version.last_version_number', $next_api_version);
    return $next_api_version;
  }

}
