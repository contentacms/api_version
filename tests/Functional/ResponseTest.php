<?php

namespace Drupal\Tests\api_number\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * @group api_version
 */
class ResponseTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['api_version'];

  public function testResponseHeader() {
    $this->drupalGet('<front>');
    $this->assertSession()->responseHeaderEquals('X-Drupal-ApiVersion', '1.0.0');
  }


}
