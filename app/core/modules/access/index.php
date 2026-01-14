<?php
use App\Helpers\ApiResponse;

if (defined('REQUEST_TYPE') && REQUEST_TYPE === 'store') {

  if (isset($_GET['s']) && $_GET['s'] === 'facebook') {
    require 'facebook_login.php';
    $facebook = new facebook_login();
  } else {
    require 'local_login.php';
    $login = new AppAccess();
  }

  switch ($_GET['s']) {
  case 'facebook':
    return $facebook->login();
    break;
  case 'recovery':
    return $login->Recovery();
    break;
  case 'reset':
    return $login->Reset();
    break;
  default:
    return $login->Login();
    break;
  }
} else {
	error_logs([MODULE, 'Ivalid request method', __FILE__, __LINE__]);
	ApiResponse::Set(900000);
}
?>
