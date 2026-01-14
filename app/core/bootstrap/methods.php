<?php
use App\Helpers\ApiResponse;
use App\Auth\SessionSet;

function request_type() {
	global $_config;

	$request_type = $_SERVER['REQUEST_METHOD'];

  if ($request_type == 'GET' && isset($_GET['id']) && !preg_match('/(^[a-z]+)[\:]/m', $_GET['id'])) {
    $request_type = 'GETBYID';
  } elseif ($_GET['c'] == 'upload' && $request_type == 'POST' && isset($_GET['id'])) {
    $request_type = 'UPLOAD';
  }

  switch ($request_type) {
  case 'GET':
    $type = 'index';
    break;
  case 'GETBYID':
    $type = 'show';
    break;
  case 'POST':
    $type = 'store';
    break;
  case 'PUT':
    $type = 'update';
    break;
  case 'UPLOAD':
    $type = 'upload';
    break;
  case 'DELETE':
    $type = 'destroy';
    break;
  default:
    $type = $_SERVER['REQUEST_METHOD'];
    break;
  }
  if (in_array($type, $_config->valid_requests)) {
		define('REQUEST_TYPE', $type);
  } elseif(in_array($type, ['show', 'update', 'destroy']) && (!isset($_GET['id']) || !is_numeric($_GET['id']) || empty($_GET['id']))) {
		error_logs([$type, 406, 'No entry id provided', __LINE__, __FILE__]);
		ApiResponse::Set(400002);
	} elseif ($type == 'OPTIONS') {
    die();
  } else {
		error_logs([$type, 405, 'Incorrect http request method', __LINE__, __FILE__]);
		ApiResponse::Set(900000);
  }
}
SessionSet::UniqueIdentifierId();
request_type();
?>
