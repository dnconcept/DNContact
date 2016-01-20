<?php

namespace DNContactTest\Controller;

use DNContactTest\Bootstrap;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * Description of ContactControllerTest
 *
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
abstract class AbstractControllerTest extends AbstractHttpControllerTestCase
{

    /** @var ServiceLocatorInterface */
    protected $serviceManager;

    protected function setUp()
    {
        $this->serviceManager = Bootstrap::getServiceManager();
        $this->applicationConfig = $this->serviceManager->get("ApplicationConfig");
        parent::setUp();
    }

}
