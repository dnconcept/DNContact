<?php

namespace DNContactTest\Service;

use Bootstrap;
use DNContact\Service\AdminMailService;
use PHPUnit_Framework_TestCase as PHPUnit;

/**
 * Description of AdminMailServiceTest
 *
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
class AdminMailServiceTest extends PHPUnit {

   private $mailService;
   private $serviceManager;

   protected function setUp() {
      $serviceManager = $this->serviceManager = Bootstrap::getServiceManager();
      $this->mailService = $serviceManager->get("dncontact_mail_service");  
      $this->mailService->getTransport()->setCallable(function($to, $subject, $message, $headers, $parameters) {
         echo "- Mail Sent to $to with subject $subject" . PHP_EOL;
      });
   }

   //On test que la fonction callback de transport du mail a bien été appelée avec la fonction send() du service
   public function testTransportCallbackHasBeenCalled() {
      $this->assertTrue(true);
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
      $eventManager->attach(MailService::BEFORE_SEND, function() use(&$beforeSend) {
         $beforeSend = true;
      });
      $eventManager->attach(MailService::AFTER_SEND, function() use(&$afterSend) {
         $afterSend = true;
      });
      $this->mailService->send();
      $this->assertTrue($beforeSend);
      $this->assertTrue($afterSend);
   }

}
