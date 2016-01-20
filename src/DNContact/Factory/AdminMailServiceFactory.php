<?php

namespace DNContact\Factory;

use DNContact\Service\AdminMailService;
use Zend\Mail\Transport\Factory;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of AdminMailServiceFactory
 *
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
class AdminMailServiceFactory implements FactoryInterface {

  public function createService(ServiceLocatorInterface $serviceLocator) {
    $moduleOptions = $serviceLocator->get("dncontact_module_options");
    $config = $serviceLocator->get("config")["dn-contact"];
    $mailTransport = Factory::create(isset($config["mail_transport"]) ? $config["mail_transport"] : []);
    $service = new AdminMailService($mailTransport, $moduleOptions);
    $service->setServiceLocator($serviceLocator);
    return $service;
  }

}
