<?php

namespace DNContact\Options;

/**
 * Description of MapInterface
 *
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
interface MapOptionsInterface {

  /**
   * Options for the map
   * @return array
   */
   public function getOptions();

   /**
    * Center for the map
    * @return string
    * @example "46, -1"
    */
   public function getCenter();

   /**
    * Get info for the google map InfoWindow
    * @return string 
    */
   public function getInfo();
}
