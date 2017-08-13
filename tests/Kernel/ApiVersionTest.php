<?php

namespace Drupal\Tests\config_override\Kernel;

use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\KernelTests\KernelTestBase;

/**
 * @group api_version
 */
class ApiVersionTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['entity_test', 'field', 'user', 'api_version'];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    $this->installEntitySchema('entity_test');
  }

  protected function apiVersion() {
    return \Drupal::service('api_version.calculator')->getApiVersion()->toSemanticString();
  }

  public function testFullConfigChange() {
    $this->assertEquals('1.0.0', $this->apiVersion());

    FieldStorageConfig::create([
      'entity_type' => 'entity_test',
      'field_name' => 'field_required',
      'type' => 'integer',
    ])->save();

    FieldConfig::create([
      'entity_type' => 'entity_test',
      'field_name' => 'field_required',
      'bundle' => 'entity_test',
    ])->save();

    // Note: There have been two changes in the meantime. Is there a way to put those changes into one group?
    $this->assertEquals('3.0.0', $this->apiVersion());
  }

}
