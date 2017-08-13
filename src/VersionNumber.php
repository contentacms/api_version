<?php

namespace Drupal\api_version;

/**
 * Represents some pseudo semantic versioning for content.
 *
 * Note: Major version represent changes in content, which break meaning,
 * minor changes are changes with minimal corrections/additions.
 */
class VersionNumber {

  protected $majorVersion;

  protected $minorVersion;

  protected $patchVersion;

  /**
   * Creates a new VersionNumber instance.
   *
   * @param int $majorVersion
   * @param int $minorVersion
   * @param int $patchVersion
   */
  public function __construct($majorVersion = 0, $minorVersion = 0, $patchVersion = 0) {
    $this->majorVersion = $majorVersion;
    $this->minorVersion = $minorVersion;
    $this->patchVersion = $patchVersion;
  }

  /**
   * @return int
   */
  public function getMajorVersion() {
    return $this->majorVersion;
  }

  /**
   * @return int
   */
  public function getMinorVersion() {
    return $this->minorVersion;
  }

  /**
   * @return int
   */
  public function getPatchVersion() {
    return $this->patchVersion;
  }

  /**
   * @return \Drupal\api_version\VersionNumber
   */
  public function increaseMajorVersion() {
    return new static(
      $this->majorVersion + 1,
      0,
      0
    );
  }

  /**
   * @return \Drupal\api_version\VersionNumber
   */
  public function increaseMinorVersion() {
    return new static(
      $this->majorVersion,
      $this->minorVersion + 1,
      0
    );
  }

  /**
   * @return \Drupal\api_version\VersionNumber
   */
  public function increasePatchVersion() {
    return new static(
      $this->majorVersion,
      $this->minorVersion,
      $this->patchVersion + 1
    );
  }

  /**
   * @return string
   */
  public function toSemanticString() {
    $parts = [];
    $parts[] = $this->majorVersion;
    $parts[] = $this->minorVersion;
    $parts[] = $this->patchVersion;
    return implode('.', $parts);
  }

  public static function fromSemanticString($version_string) {
    $parts = explode('.', $version_string);

    if (count($parts) > 3) {
      throw new \InvalidArgumentException('Its not allowed to have more than major, minor and semantic version.');
    }

    if (count($parts) === 1) {
      $parts[] = 0;
    }
    if (count($parts) === 2) {
      $parts[] = 0;
    }

    return new VersionNumber($parts[0], $parts[1], $parts[2]);
  }

}
