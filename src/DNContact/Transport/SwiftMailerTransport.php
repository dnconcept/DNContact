<?php

namespace DNContact\Service;

use DNContact\ContactException;
use Swift_Mailer;
use Swift_MailTransport;
use Swift_Message;
use Zend\Mail\Message;
use Zend\Mail\Transport\TransportInterface;

/**
 * Description of SwiftMailerTransport
 *
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
class SwiftMailerTransport implements TransportInterface {

  public function send(Message $message) {
    //create transport
    $transport = Swift_MailTransport::newInstance();

    //Create mailer
    $mailer = Swift_Mailer::newInstance($transport);

    //Create the message
    $this->createMessage($message);

    //Send the message
    if (!$mailer->send($message)) {
      throw new ContactException("Une erreure est apparue pendant l'envoi du message avec Swift :( Veuillez réessayer", 400);
    }
  }

  /**
   * Create the swift_message from zend messsage
   * @param Message $message
   * @return Swift_Message
   */
  private function createMessage(Message $message) {
    $Swift = Swift_Message::newInstance();
    foreach ($message->getTo() as $value) {
      $Swift->setTo($value->getEmail(), $value->getName());
    }
    foreach ($message->getFrom() as $value) {
      $Swift->setFrom($value->getEmail(), $value->getName());
    }
    $Swift->setSubject($message->getSubject());
    $headers = $message->getHeaders();
    $Swift->setBody($message->getBodyText(), $headers->get('content-type'), $headers->get('charset'));
    return $Swift;
  }

}
