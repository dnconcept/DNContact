<?php

namespace DNContactTest\Controller;

use Bootstrap;
use PHPUnit_Framework_TestCase as PHPUnit;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Mvc\Router\RouteMatch;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Description of ContactControllerTest
 *
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
abstract class AbstractControllerTest extends PHPUnit {

   /** @var AbstractActionController */
   protected $controller;

   /** @var ServiceLocatorInterface */
   protected $serviceManager;

   /** @var MvcEvent */
   protected $event;

   /** @var RouteMatch */
   protected $routeMatch;

   /** @var Request */
   protected $request;

   abstract protected function getController();

   protected function setUp() {
      $this->serviceManager = Bootstrap::getServiceManager();
      $this->controller = $this->getController();
      $this->request = new Request();
      $this->routeMatch = new RouteMatch([]);

      $this->event = new MvcEvent();
      $config = $this->serviceManager->get('Config');
      $routerConfig = isset($config['router']) ? $config['router'] : array();
      $router = HttpRouter::factory($routerConfig);
      $this->event->setRouter($router);
      $this->event->setRouteMatch($this->routeMatch);

      $this->controller->setEvent($this->event);
      $this->controller->setServiceLocator($this->serviceManager);
   }

   protected function callTestAction($action) {
      $this->routeMatch->setParam('action', $action);
      $this->controller->dispatch($this->request);
      $view = $this->event->getResult();
      $response = $this->controller->getResponse();

      $this->assertInstanceOf("Zend\Http\Response", $response, "The response must be type of Zend\Http\Response");
      $this->assertInstanceOf("Zend\View\Model\ViewModel", $view, "The response must be type of Zend\View\Model\ViewModel");

      $this->assertTrue($response->getStatusCode() === 200, "The response status code must be 200");
   }

}
