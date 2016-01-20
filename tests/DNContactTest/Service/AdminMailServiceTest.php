<?php

namespace DNContactTest\Service;

use DNContactTest\Bootstrap;
use DNContact\Service\AdminMailService;

/**
 * Description of AdminMailServiceTest
 *
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
class AdminMailServiceTest extends \PHPUnit_Framework_TestCase {

   /** @var  AdminMailService */
   private $mailService;
   private $serviceManager;

   protected function setUp() {
      $serviceManager = $this->serviceManager = Bootstrap::getServiceManager();
      $this->mailService = $serviceManager->get("dncontact_mail_service");  
      $this->mailService->getTransport()->setCallable([$this, "callableTest"]);
   }

   /**
    * Replacement function for testing emails
    * @param $to
    * @param $subject
    * @param $message
    * @param $headers
    * @param $parameters
    */
   public function callableTest($to, $subject, $message, $headers, $parameters) {
      echo "- Mail Sent to $to with subject $subject" . PHP_EOL;
   }

   //On test que la fonction callback de transport du mail a bien été appelée avec la fonction send() du service
   public function testTransportCallbackHasBeenCalled() {
      $test = false;
      $this->mailService->getTransport()->setCallable(function() use (&$test) {
         $test = true;
      });
      $this->assertFalse($test, "La fonction callBack du service ne doit pas être appelée avant l'envoi du message !");
      $this->mailService->send();
      $this->assertTrue($test, "La fonction callBack du service doit être appelée après l'envoi du message !");
   }

   //On test que les événements du service sont bien déclenché
   public function testAttachedEventsHasBeenTriggered() {
      $beforeSend = false;
      $afterSend = false;
      $eventManager = $this->mailService->getEventManager();
      $eventManager->attach(AdminMailService::BEFORE_SEND, function() use(&$beforeSend) {
         $beforeSend = true;
      });
      $eventManager->attach(AdminMailService::AFTER_SEND, function() use(&$afterSend) {
         $afterSend = true;
      });
      $this->mailService->send();
      $this->assertTrue($beforeSend);
      $this->assertTrue($afterSend);
   }

   public function testGetTransport()
   {
     $this->assertInstanceOf(\Zend\Mail\Transport\Sendmail::class, $this->mailService->getTransport());
   }

   public function testGetMessage()
   {
      $this->assertInstanceOf(\Zend\Mail\Message::class, $this->mailService->getMessage());
   }

}
