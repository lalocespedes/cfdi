<?php

namespace lalocespedes\Cfdi\Validation;

use Respect\Validation\Exceptions\NestedValidationException;

/**
 *
 */
class Comprobante
{
    protected $errors = [];
    protected $required;

    public function validate(array $array, array $rules)
    {
        if(!count($array)) {
            $this->errors = ["Nodo Comprobante esta vacio"];
            return $this;
        }

        $this->required($array);

        foreach ($rules as $field => $rule) {

           try {
               if(array_key_exists($field, $array)) {
                   $rule->setName(ucfirst($field))->assert($array[$field]);
               }
           } catch (NestedValidationException $e) {
               $this->errors = array_merge($this->errors, $e->getMessages());
           }
        }

        return $this;
    }

    public function failed()
    {
        return !empty($this->errors);
    }

    public function errors()
    {
        return $this->errors;
    }

    public function required(array $array)
    {
         $this->required = [
            "Version",
            "Fecha",
            "Sello",
            "NoCertificado",
            "Certificado",
            "SubTotal",
            "Moneda",
            "Total",
            "TipoDeComprobante",
            "LugarExpedicion"
        ];

        foreach($this->required as $key => $value){
            if(!array_key_exists($value, $array)) {
                array_push($this->errors, "El attributo {$value} is required");
            }
        }
    }
}
