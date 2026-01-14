<?php
namespace App\Helpers;
/**
 * $options = array(
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
abstract class HCaptcha {
	static public function Validate(String $token) {
		global $_config;
		$url =	$_config->hcaptcha->url;
		$response = CurlRequest::Init([
			CURLOPT_URL	=> $url,
			CURLOPT_POST => 1,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_POSTFIELDS => [
				'response' => $token,
				'secret' => $_config->hcaptcha->secret
			]
		]);
		$body = json_decode($response['body']);
		if(!$body->success) {
			throw new \AppException($response['body'], 905000);
		}
		return $response;
	}
}
?>
