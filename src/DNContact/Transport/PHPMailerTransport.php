<?php

namespace DNContact\Service;

use DNContact\ContactException;
use PHPMailer;
use Zend\Mail;
use Zend\Mail\Transport\TransportInterface;

/**
 * Description of PHPMailer
 *
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
class PHPMailerTransport implements TransportInterface {

  /** @var PHPMailer */
  private $PHPMailer;

  public function __construct(PHPMailer $PHPMailer) {
    //Set configuration
    $this->PHPMailer = $PHPMailer;
  }

  /**
   * Set Options for PHPMailer
   * @param PHPMailerOptions $options
   * @return PHPMailerTransport
   */
  public function setOptions(PHPMailerOptions $options) {
    $PHPMailer = $this->PHPMailer;
    $PHPMailer->AuthType = $options->getAuthType();
    $PHPMailer->Host = $options->getHost();
    $PHPMailer->Mailer = $options->getMailer();
    $PHPMailer->Password = $options->getPassword();
    $PHPMailer->Port = $options->getPort();
    $PHPMailer->SMTPAuth = $options->getSMTPAuth();
    $PHPMailer->SMTPDebug = $options->getSMTPDebug();
    $PHPMailer->SMTPSecure = $options->getSMTPSecure();
    $PHPMailer->Username = $options->getUsername();
    return $this;
  }

  public function send(Mail\Message $message) {
    $PHPMailer = $this->PHPMailer;
    foreach ($message->getTo() as $value) {
      $PHPMailer->AddAddress($value->getEmail(), $value->getName());
    }
    foreach ($message->getFrom() as $value) {
      $PHPMailer->SetFrom($value->getEmail(), $value->getName());
    }
    $PHPMailer->IsHTML(true);
    $PHPMailer->Subject = $message->getSubject();
    $PHPMailer->Body = $message->getBodyText();
    if (!$PHPMailer->Send()) {
      throw new ContactException("An error occurs while sending the message with PHPMailer");
    }
  }

}
