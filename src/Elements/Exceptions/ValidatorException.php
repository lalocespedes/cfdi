<?php

namespace lalocespedes\Cfdi\Elements\Exceptions;

use Exception;

class ValidatorException extends Exception
{
  private $_options;

  public function __construct(
    $message,
    $code = 0,
    Exception $previous = null,
    $options = ['params'])
  {
    parent::__construct(json_encode($message), $code, $previous);
    $this->_options = $options;
  }

  /**
   * Returns the json decoded message.
   *
   * @param bool $assoc
   *
   * @return mixed
   */
  public function getDecodedMessage($assoc = false)
  {
      return json_decode($this->getMessage(), $assoc);
  }
}
