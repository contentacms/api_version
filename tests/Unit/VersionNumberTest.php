<?php

namespace Drupal\Tests\api_version\Unit;

use Drupal\api_version\VersionNumber;

/**
 * @coversDefaultClass \Drupal\content_revision_number\VersionNumber
 * @group content_revision_number
 */
class VersionNumberTest extends \PHPUnit_Framework_TestCase {

  /**
   * @covers ::__construct
   * @covers ::getMinorVersion
   * @covers ::getMajorVersion
   */
  public function testGetter() {
    $this->assertEquals(1, (new VersionNumber(1, 0, 3))->getMajorVersion());
    $this->assertEquals(0, (new VersionNumber(1, 0, 3))->getMinorVersion());
    $this->assertEquals(3, (new VersionNumber(1, 0, 3))->getPatchVersion());
    $this->assertEquals(2, (new VersionNumber(2, 1, 0))->getMajorVersion());
    $this->assertEquals(1, (new VersionNumber(2, 1, 0))->getMinorVersion());
    $this->assertEquals(0, (new VersionNumber(2, 1, 0))->getPatchVersion());
  }

  /**
   * @coversDefaultClass ::increaseMajorVersion
   */
  public function testIncreaseMajorVersion() {
    $version_number = (new VersionNumber(0, 1, 3));
    $this->assertEquals(1, $version_number->increaseMajorVersion()
      ->getMajorVersion());
    $this->assertEquals(0, $version_number->increaseMajorVersion()
      ->getMinorVersion());
    $this->assertEquals(0, $version_number->increaseMajorVersion()
      ->getPatchVersion());
  }

  /**
   * @coversDefaultClass ::increaseMinorVersion
   */
  public function testIncreaseMinorVersion() {
    $version_number = (new VersionNumber(2, 1, 2));
    $this->assertEquals(2, $version_number->increaseMinorVersion()->getMajorVersion());
    $this->assertEquals(2, $version_number->increaseMinorVersion()->getMinorVersion());
    $this->assertEquals(0, $version_number->increaseMinorVersion()->getPatchVersion());
  }

  /**
   * @coversDefaultClass ::increasePatchVersion
   */
  public function testIncreasePatchVersion() {
    $version_number = (new VersionNumber(2, 1, 2));
    $this->assertEquals(2, $version_number->increasePatchVersion()->getMajorVersion());
    $this->assertEquals(1, $version_number->increasePatchVersion()->getMinorVersion());
    $this->assertEquals(3, $version_number->increasePatchVersion()->getPatchVersion());
  }

  /**
   * @covers ::toSemanticString
   */
  public function testToSemanticString() {
    $version_number = (new VersionNumber(2, 1, 4));
    $this->assertEquals('2.1.4', $version_number->toSemanticString());
  }

  /**
   * @covers ::fromSemanticString
   */
  public function testFromSemanticString() {
    $version_number = VersionNumber::fromSemanticString('2.1');
    $this->assertEquals(2, $version_number->getMajorVersion());
    $this->assertEquals(1, $version_number->getMinorVersion());
    $this->assertEquals(0, $version_number->getPatchVersion());

    $version_number = VersionNumber::fromSemanticString('2.1.4');
    $this->assertEquals(2, $version_number->getMajorVersion());
    $this->assertEquals(1, $version_number->getMinorVersion());
    $this->assertEquals(4, $version_number->getPatchVersion());
  }

}
