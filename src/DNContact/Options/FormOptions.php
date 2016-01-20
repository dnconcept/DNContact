<?php

namespace DNContact\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Contact Form Options
 * @author Nicolas Desprez <contact@dnconcept.fr>
 */
class FormOptions extends AbstractOptions {

  /** @int Min length of message */
  private $minLength = 23;

  /** @int Max length of message */
  private $maxLength = 1500;

  /**
   * @return mixed
   */
  public function getMinLength()
  {
    return $this->minLength;
  }

  /**
   * @param mixed $minLength
   * @return FormOptions
   */
  public function setMinLength($minLength)
  {
    $this->minLength = $minLength;
    return $this;
  }

  /**
   * @return mixed
   */
  public function getMaxLength()
  {
    return $this->maxLength;
  }

  /**
   * @param mixed $maxLength
   * @return FormOptions
   */
  public function setMaxLength($maxLength)
  {
    $this->maxLength = $maxLength;
    return $this;
  }

}
