<?php

namespace lalocespedes\Cfdi;

use DOMDocument;

class Cfdi
{

  public $xml;

  public $comprobante;

  public $errors;

  public function __construct()
  {
    $this->xml = new DOMDocument("1.0", "UTF-8");
    $this->xml->formatOutput = true;
  }
}
