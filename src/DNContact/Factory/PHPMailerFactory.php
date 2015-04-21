<?php

namespace DNContact\Factory;

use DNContact\Service\PHPMailer;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of PHPMailerFactory
 *
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
class PHPMailerFactory implements FactoryInterface {

  public function createService(ServiceLocatorInterface $serviceLocator) {
    $config = $serviceLocator->get("config")["dn-contact"];
    $QuPHPMailer = $serviceLocator->get('QuPHPMailer');
    $PHPMailerOptions = new \DNContact\Service\PHPMailerOptions(isset($config['php_mailer']) ? $config['php_mailer'] : []);
    $service = new PHPMailer($QuPHPMailer->Mail());
    $service->setOptions($PHPMailerOptions);
    return $service;
  }

}
