<?php

namespace DNContact\Factory;

use DNContact\Form\ContactForm;
use DNContact\Options\FormOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of ContactControllerFactory
 *
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
class ContactFormFactory implements FactoryInterface {

  public function createService(ServiceLocatorInterface $serviceLocator) {
    $options = $serviceLocator->get('Config')['dn-contact'];
    $formOptions = isset($options["form-options"]) ? $options["form-options"] : [];
    return new ContactForm(new FormOptions($formOptions));
  }

}
