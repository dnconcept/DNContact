<?php

namespace DNContact\Service;

/**
 * Description of PHPMailerOptions
 *
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
class PHPMailerOptions extends Zend\Stdlib\AbstractOptions {

  private $Host = 'localhost';
  private $Port = 25;
  private $SMTPSecure = '';
  private $SMTPAuth = false;
  private $SMTPDebug = false;
  private $Username = '';
  private $Password = '';
  private $AuthType = '';
  private $Mailer = 'mail';

  /**
   * Sets the SMTP hosts.
   *
   * All hosts must be separated by a
   * semicolon.  You can also specify a different port
   * for each host by using this format: [hostname:port]
   * (e.g. "smtp1.example.com:25;smtp2.example.com").
   * Hosts will be tried in order.
   * @var string
   */
  public function getHost() {
    return $this->Host;
  }

  /**
   * Sets the default SMTP server port.
   * @var int
   */
  public function getPort() {
    return $this->Port;
  }

  /**
   * Sets connection prefix. Options are "", "ssl" or "tls"
   * @var string
   */
  public function getSMTPSecure() {
    return $this->SMTPSecure;
  }

  /**
   * Sets SMTP authentication. Utilizes the Username and Password variables.
   * @var bool
   */
  public function getSMTPAuth() {
    return $this->SMTPAuth;
  }

  /**
   * Sets SMTP username.
   * @var string
   */
  public function getUsername() {
    return $this->Username;
  }

  /**
   * Sets SMTP password.
   * @var string
   */
  public function getPassword() {
    return $this->Password;
  }

  /**
   *  Sets SMTP auth type. Options are LOGIN | PLAIN | NTLM  (default LOGIN)
   *  @var string
   */
  public function getAuthType() {
    return $this->AuthType;
  }

  /**
   * Sets SMTP class debugging on or off.
   * @var bool
   */
  public function getSMTPDebug() {
    return $this->SMTPDebug;
  }

  public function setHost($Host) {
    $this->Host = $Host;
    return $this;
  }

  public function setPort($Port) {
    $this->Port = $Port;
    return $this;
  }

  public function setSMTPSecure($SMTPSecure) {
    $this->SMTPSecure = $SMTPSecure;
    return $this;
  }

  public function setSMTPAuth($SMTPAuth) {
    $this->SMTPAuth = $SMTPAuth;
    return $this;
  }

  public function setUsername($Username) {
    $this->Username = $Username;
    return $this;
  }

  public function setPassword($Password) {
    $this->Password = $Password;
    return $this;
  }

  public function setAuthType($AuthType) {
    $this->AuthType = $AuthType;
    return $this;
  }

  public function setSMTPDebug($SMTPDebug) {
    $this->SMTPDebug = $SMTPDebug;
    return $this;
  }

  /**
   * Method to send mail: ("mail", "sendmail", or "smtp").
   * @var string
   */
  public function getMailer() {
    return $this->Mailer;
  }

  public function setMailer($Mailer) {
    $this->Mailer = $Mailer;
    return $this;
  }

}
