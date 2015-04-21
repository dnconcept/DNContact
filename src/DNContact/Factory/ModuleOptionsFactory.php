<?php

namespace DNContact\Factory;

use DNContact\Options\ModuleOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of ModuleOptionsFactory
 *
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
class ModuleOptionsFactory implements FactoryInterface {

   public function createService(ServiceLocatorInterface $serviceLocator) {
      $config = $serviceLocator->get('Config');
      $options = isset($config['dn-contact']) ? $config['dn-contact'] : [];
      return new ModuleOptions($options);
   }

}
