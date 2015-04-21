<?php

namespace DNContact\Factory;

use DNContact\Controller\ContactController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of ContactControllerFactory
 *
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
class ContactControllerFactory implements FactoryInterface {

  public function createService(ServiceLocatorInterface $controllerManager) {
    /* @var ServiceLocatorInterface $serviceLocator */
    $serviceLocator = $controllerManager->getServiceLocator();
    $mailService = $serviceLocator->get("dncontact_mail_service");
    $form = $serviceLocator->get("dncontact_form");
    $mapOptions = $serviceLocator->get("dncontact_map_options");
    return new ContactController($mailService, $form, $mapOptions);
  }

}
