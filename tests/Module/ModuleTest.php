<?php

namespace DNContactTest\Module;

use PHPUnit_Framework_TestCase as PHPUnit;

/**
 * Description of ContactControllerTest
 *
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
class ModuleTest extends PHPUnit {

   private $serviceManager;

   protected function setUp() {
      $this->serviceManager = \Bootstrap::getServiceManager();
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
   }

   /**
    * Tests des services disponibles
    */
   public function testGetModuleOptions() {
      $module_options = $this->serviceManager->get('dncontact_module_options');
      $this->assertInstanceOf("DNContact\Options\ModuleOptions", $module_options);
      
      $mail_service = $this->serviceManager->get('dncontact_mail_service');
      $this->assertInstanceOf("DNContact\Service\AdminMailService", $mail_service);
      
      $map_options = $this->serviceManager->get('dncontact_map_options');
      $this->assertInstanceOf("DNContact\Options\MapOptions", $map_options);
   }

}
