<?php

namespace DNContactTest\Module;

use DNContact\Service\AdminMailService;
use DNContactTest\Bootstrap;
use DNContact\Options\ModuleOptions;
use DNContact\Options\MapOptions;
use DNContact\Form\ContactForm;

/**
 * Description of ContactControllerTest
 *
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
class ModuleTest extends \PHPUnit_Framework_TestCase {

   private $serviceManager;

   protected function setUp() {
      $this->serviceManager = Bootstrap::getServiceManager();
//      $this->applicationConfig = $this->serviceManager->get("ApplicationConfig");
   }

   public function testConfig() {
      $config = $this->serviceManager->get('Config');
      $this->assertTrue(isset($config["dn-contact"]));
   }

   /**
    * Tests des services disponibles
    */
   public function testHasServices() {
      $this->assertTrue($this->serviceManager->has('dncontact_module_options'));
      $this->assertTrue($this->serviceManager->has('dncontact_mail_service'));
      $this->assertTrue($this->serviceManager->has('dncontact_map_options'));
      $this->assertTrue($this->serviceManager->has('dncontact_form'));
   }

   public function testGet_dncontact_module_options() {
      $dncontact_module_options = $this->serviceManager->get('dncontact_module_options');
      $this->assertInstanceOf(ModuleOptions::class, $dncontact_module_options);
   }

   public function testGet_dncontact_mail_service() {
      $dncontact_mail_service = $this->serviceManager->get('dncontact_mail_service');
      $this->assertInstanceOf(AdminMailService::class, $dncontact_mail_service);
   }

   public function testGet_dncontact_map_options() {
      $dncontact_map_options = $this->serviceManager->get('dncontact_map_options');
      $this->assertInstanceOf(MapOptions::class, $dncontact_map_options);
   }

   public function testGet_dncontact_form() {   
      $dncontact_form = $this->serviceManager->get('dncontact_form');
      $this->assertInstanceOf(ContactForm::class, $dncontact_form);
   }

}
