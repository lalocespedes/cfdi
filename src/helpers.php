<?php

function validateRules($val) {

  $val = preg_replace('/\s\s+/', ' ', $val);   // Regla 5a y 5c

  $val = trim($val); // Regla 5b

  if (strlen($val)>0) { // Regla 6
  $val = str_replace(array('"','>','<'),"'",$val);  // &...;
  $val = str_replace("|","/",$val); // Regla 1
    return $val;
  }

  return null;
}
