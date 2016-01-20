<?php

namespace DNContactTest\Controller;

use DNContact\Controller\ContactController;

/**
 * Description of ContactControllerTest
 *
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
class ContactControllerTest extends AbstractControllerTest {

  public function testIndexActionCanBeAccessed() {
    $this->dispatch("contact");
  }

}
