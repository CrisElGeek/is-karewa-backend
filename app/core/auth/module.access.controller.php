<?php
namespace App\Auth;
use App\Auth\SessionSet;
use App\Auth\HashAuth;
use App\Helpers\ApiResponse;

abstract class ModuleHandler {
	public static function Validate(array $accepted_methods, $class) {
		$rType = REQUEST_TYPE;
		if (array_key_exists($rType, $accepted_methods) && method_exists($class, $rType)) {
      $auth  = $accepted_methods[$rType][0];
			$roles = $accepted_methods[$rType][1];
			$options = isset($accepted_methods[$rType][2]) ? $accepted_methods[$rType][2] : NULL;
			$altAuth = false;
      if ($options && isset($options['hash']) && $options['hash']) {
				$altAuth = HashAuth::Validate($options['hash']);
			}
    } else {
			error_logs([MODULE, 405, 'No existe el método dentro de la clase especificada: ' . $rType]);
			ApiResponse::Set(900000);
		}
		$authenticated = false;
		$headers = apache_request_headers();
		$authSet = (isset($headers['Authorization']) && !empty($headers['Authorization'])) || (isset($headers['authorization']) && !empty($headers['authorization']));
    $access_token	= $headers['Authorization'] ?: $headers['authorization'];
		if($auth || $authSet) {
			try {
				$access_granted = SessionSet::Validate($access_token);
			} catch(\AppException $e) {
				if($auth) {
					ApiResponse::Set($e->errorCode());
				}
			}
			$authenticated = $altAuth || ($access_granted && (defined('USER_ROLE') && ($roles === NULL || (in_array(USER_ROLE, $roles) && $auth === true))));
			if($authenticated) {
				define('AUTHENTICATED', $authenticated);
			}
		}
    $validation = $auth === false || $authenticated; // La validacion se realizo correctamente o bien no es necesario autenticacion
    if ($validation) {
			return $class->$rType();
    } else {
			error_logs([MODULE, 403, 'No access allowed', __LINE__, __FILE__]);
			ApiResponse::Set(901004);
    }
  }
}
?>
