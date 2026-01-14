<?php
namespace App\Helpers;
use App\Helpers\AppException;

/**
 * $options = array(
 *  CURLOPT_URL						=> $url,
 *  curlopt_returntransfer => true,       // return web page
 *  curlopt_header         => false,      // don't return headers
 *  curlopt_followlocation => true,       // follow redirects
 *  curlopt_encoding       => '',         // handle all encodings
 *  curlopt_useragent      => 'spider',   // who am i
 *  curlopt_autoreferer    => true,       // set referer on redirect
 *  curlopt_connecttimeout => 120,        // timeout on connect
 *  curlopt_timeout        => 120,        // timeout on response
 *  curlopt_maxredirs      => 10,         // stop after 10 redirects
 *  curlopt_post           => 1,          // i am sending post data
 *  curlopt_postfields     => $curl_data, // this are my post vars
 *  curlopt_ssl_verifyhost => 0,          // don't verify ssl
 *  curlopt_ssl_verifypeer => false,      //
 *  curlopt_verbose        => 1,          //
 *);
 *
 *$ch = curl_init($url);
 *curl_setopt_array($ch, $options);
 *$content = curl_exec($ch);
 *$err     = curl_errno($ch);
 *$errmsg  = curl_error($ch);
 *$header  = curl_getinfo($ch);
 *curl_close($ch);
 */
abstract class CurlRequest {
  static public function Init(array $options) {
    $ch = curl_init();
    curl_setopt_array($ch, $options);
    $response = curl_exec($ch);
    curl_close($ch);
    $err     = curl_errno($ch);
    $errmsg  = curl_error($ch);
    $headers = curl_getinfo($ch);
    if ($err) {
      throw new \AppException($errmsg, 905000);
    }
    return [
      'body'    => $response,
			'headers' => $headers,
			'err_code'	=> $err,
			'err_msg'	=> $errmsg
    ];
  }
}
?>
