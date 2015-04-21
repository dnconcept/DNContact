<?php

namespace DNContact\Factory;

use DNContact\Options\MapOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of MapOptionsFactory
 *
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
class MapOptionsFactory implements FactoryInterface {

   public function createService(ServiceLocatorInterface $serviceLocator) {
      $options = $serviceLocator->get('Config')['dn-contact'];
      $mapOptions = isset($options["gmap"]) ? $options["gmap"] : [];
      return new MapOptions($mapOptions);
   }

}
