<?php

namespace MFevola\SimplyEmail;

use Symfony\Component\Yaml\Yaml;

/**
 * Helper class to retrieve config default values
 * 
 * Class Config
 * @package MFevola\SimplyEmail
 */
class Config
{
  /** @var array */
  private $data;

  /**
   * Uses debug backtrace to get the project root
   *
   * Config constructor.
   */
  public function __construct()
  {
    $configName = "simply-email.yml";
    $firstCall = debug_backtrace()[0]["file"];
    $root = explode("/vendor", $firstCall)[0];

    $this->data = Yaml::parseFile(
      sprintf(
        "%s/%s",
        $root,
        $configName
      )
    );
  }

  /**
   * @return array
   */
  public function getData()
  {
    return $this->data;
  }
}
