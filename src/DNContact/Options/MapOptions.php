<?php

namespace DNContact\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Description of MapOptions
 *
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
class MapOptions extends AbstractOptions implements MapOptionsInterface {

  /** @var string info for the google map InfoWindow */
  private $info;

  /** @var array options for the map */
  private $options;

  /** @var string center for the map */
  private $center = "46, -1";

  public function getOptions() {
    return $this->options;
  }

  /**
   * @param array $options
   * @return MapOptions
   */
  public function setOptions(array $options) {
    $this->options = $options;
  }

  public function getCenter() {
    return $this->center;
  }

  /**
   * @param string $center
   * @return MapOptions
   */
  public function setCenter($center) {
    $this->center = $center;
    return $this;
  }

  public function getInfo() {
    return $this->info;
  }

  /**
   * @param string $info
   * @return MapOptions
   */
  public function setInfo($info) {
    $this->info = $info;
    return $this;
  }

}
