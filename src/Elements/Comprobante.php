<?php

namespace lalocespedes\Cfdi\Elements;

use Respect\Validation\Validator as v;
use lalocespedes\Cfdi\Validation\Comprobante as validatorComprobante;
use lalocespedes\Cfdi\Elements\Exceptions\ValidatorException;
use lalocespedes\Cfdi\Cfdi;

class Comprobante extends Cfdi
{
  protected $fields = [
    'Version',
    'Serie',
    'Folio',
    'Fecha',
    'Sello',
    'FormaPago',
    'NoCertificado',
    'Certificado',
    'CondicionesDePago',
    'SubTotal',
    'Descuento',
    'Moneda',
    'TipoCambio',
    'Total',
    'TipoDeComprobante',
    'MetodoPago',
    'LugarExpedicion',
    'Confirmacion'
  ];

  public function __construct($xml, $data)
  {

    v::with('lalocespedes\\Cfdi\\Validation\\Rules');

    $this->comprobante = $xml->appendChild(
      $xml->createElementNS("http://www.sat.gob.mx/cfd/3", "cfdi:Comprobante")
    );

    $this->comprobante->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
    $this->comprobante->setAttribute('xsi:schemaLocation', 'http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd');

    $this->validate($data);

    foreach($data as $key => $value) {
      if(validateRules($value)) {
        $this->comprobante->setAttribute($key, $value);
      }
    }
  }

  private function validate(array $data) {
    foreach($data as $key => $attr) {
      if(!in_array($key, $this->fields)) {
        throw new ValidatorException(["El attributo {$key} no existe en el nodo Comprobante"], 1);
      }
    }

    $valid = new validatorComprobante();
    $valid->validate($data, [
        'Version' => v::notBlank(),
        'Total' => v::numeric(),
        'Fecha' => v::date('Y-m-d\TH:i:s')->between(\Carbon\Carbon::now()->subHours(48)->format('Y-m-d\TH:i:s'), \Carbon\Carbon::now()->format('Y-m-d\TH:i:s')),
        'TipoDeComprobante' => v::notEmpty()->stringType()->TipoDeComprobanteValid(),
      ]);

    if($valid->failed()) {
      throw new ValidatorException($valid->errors(), 1);
    }
  }
}
