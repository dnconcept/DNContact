<?php

namespace DNContact\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Description of ModuleOptions
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
class ModuleOptions extends AbstractOptions {

  protected $__strictMode__ = false;

  /** @string redirect route after sending message */
  private $redirectRoute = "home";

  /** @string administrateur email */
  private $adminMail = null;

  /** @string administrateur name */
  private $adminName = "admin";

  /** @string address to display  */
  private $address;

  /** @boolean enable Gmap or not */
  private $useGmap = true;

  /** @string Success message on email sending */
  private $successMessage = "Votre message a été correctement envoyé !";

  public function getAdminMail() {
    return $this->adminMail;
  }

  /**
   * @param string $adminMail
   * @return ModuleOptions
   */
  public function setAdminMail($adminMail) {
    $this->adminMail = $adminMail;
    return $this;
  }

  public function getAdminName() {
    return $this->adminName;
  }

  /**
   * @param string $adminName
   * @return ModuleOptions
   */
  public function setAdminName($adminName) {
    $this->adminName = $adminName;
    return $this;
  }

  public function getUseGmap() {
    return $this->useGmap;
  }

  /**
   * @param boolean $useGmap
   * @return ModuleOptions
   */
  public function setUseGmap($useGmap) {
    $this->useGmap = $useGmap;
    return $this;
  }

  public function getRedirectRoute() {
    return $this->redirectRoute;
  }

  public function setRedirectRoute($redirectRoute) {
    $this->redirectRoute = $redirectRoute;
    return $this;
  }

  public function getAddress() {
    return $this->address;
  }

  /**
   * @param string $address
   * @return ModuleOptions
   */
  public function setAddress($address) {
    $this->address = $address;
    return $this;
  }

  public function getSuccessMessage() {
    return $this->successMessage;
  }

  public function setSuccessMessage($successMessage) {
    $this->successMessage = $successMessage;
    return $this;
  }

}
