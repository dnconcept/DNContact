<?php

namespace DNContactTest\Controller;

use DNContact\Controller\ContactController;

/**
 * Description of ContactControllerTest
 *
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
class ContactControllerTest extends AbstractControllerTest {

   protected function getController() {
      return new ContactController($this->serviceManager->get("dncontact_mail_service"));
   }

   protected function setUp() {
      parent::setUp();
      $this->routeMatch->setParam('controller', 'DNContact\Controller\Contact');
   }

   public function testIndexActionCanBeAccessed() {
      $this->callTestAction("contact");
   }

}
