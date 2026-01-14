<?php
/**
 * Convierte un string a un formato amigable para url, sin espacios,
 * acentos u otros caracteres especiales.
 * @param  String $str       String de texto a ser convertido
 * @param  String $separator Tipo de separados para espacios y otros caracteres
 * @param  String $caps      Capitalización, si se indica puede uppercase o lowercase
 * @return String            String convertido
 */
function toAlphanumeric(string $str, string $separator = "-", string $caps = 'lowercase') {
  $strTxt   = trim(strip_tags($str));
  $utfChars = array('á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'Á' => 'a', 'É' => 'e', 'Í' => 'i', 'Ó' => 'o', 'Ú' => 'u', 'ñ' => 'n', 'Ñ' => 'n', 'ü' => 'u', 'Ü' => 'u');
  foreach ($utfChars as $key => $value) {
    $strTxt = preg_replace('/' . $key . '/', $value, $strTxt);
  }
  if ($caps == 'lowercase') {
    $strTxt = strtolower($strTxt);
  } elseif ($caps == 'uppercase') {
    $strTxt = strtoupper($strTxt);
  }
  $strTxt = preg_replace("/([^a-z0-9\-]+)/i", $separator, $strTxt);
  $strTxt = preg_replace('/' . $separator . '+/i', $separator, $strTxt);
  return trim($strTxt, $separator);
}
/**
 * Genera un string aleatorio de la longitud que se asigne
 * @param int $length Longitud del string resultante
 */
function random_string(int $length) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!º|$%&=?¿_-¡#+*^';
  $randstring = '';
  for ($i = 0; $i < $length; $i++) {
    $randstring .= $characters[mt_rand(0, strlen($characters) - 1)];
  }
  return $randstring;
}
?>
