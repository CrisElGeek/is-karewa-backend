<?php
use App\Helpers\ApiResponse;

if (defined('REQUEST_TYPE') && REQUEST_TYPE === 'store') {
  require 'local_login.php';
  $login = new AppAccess();

  switch ($_GET['s']) {
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
} elseif(defined('REQUEST_TYPE') && REQUEST_TYPE === 'index') {
  if($_GET['s'] === 'logout') {
    require 'local_login.php';
    $logout = new AppAccess();
    return $logout->Logout();
  } else {
    error_logs([MODULE, 'Ivalid request method', __FILE__, __LINE__]);
    ApiResponse::Set(900000);
  }
} else {
	error_logs([MODULE, 'Ivalid request method', __FILE__, __LINE__]);
	ApiResponse::Set(900000);
}
?>
