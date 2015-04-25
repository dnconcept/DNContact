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
    return $this->serviceManager->get('controller_manager')->get("DNContact\Controller\Contact");
  }

  protected function setUp() {
    parent::setUp();
    $this->routeMatch->setParam('controller', 'DNContact\Controller\Contact');
  }

  public function testIndexActionCanBeAccessed() {
    $this->callTestAction("contact");
  }

}
