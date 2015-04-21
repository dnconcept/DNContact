<?php

namespace DNContact;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

/**
 * Description of DNContactModule
 * 
 * Simple configurable contact form with mail service
 *
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
class Module implements
AutoloaderProviderInterface, ConfigProviderInterface, ServiceProviderInterface {
  
  public function getConfig() {
    return include __DIR__ . '/config/module.config.php';
  }

  public function getAutoloaderConfig() {
    return [
        'Zend\Loader\StandardAutoloader' => [
            'namespaces' => [
                __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
            ],
        ],
    ];
  }

  public function getServiceConfig() {
    return [
        'invokables' => [
            'dncontact_form' => 'DNContact\Form\ContactForm',
        ],
        'factories' => [
            'dncontact_module_options' => 'DNContact\Factory\ModuleOptionsFactory',
            'dncontact_map_options' => 'DNContact\Factory\MapOptionsFactory',
            'dncontact_mail_service' => 'DNContact\Factory\AdminMailServiceFactory',
        ]
    ];
  }

  public function getViewHelperConfig() {
    return [
        'invokables' => [
            '_' => 'Zend\I18n\View\Helper\Translate',
        ],
    ];
  }

}
