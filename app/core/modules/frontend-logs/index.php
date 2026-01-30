<?php
use App\Auth\moduleHandler;
use App\Helpers\ApiResponse;

require_once 'controller.php';
$frontEndLogs = new FrontendLogs($request);

$accepted_methods = [
  'store'   => [false, NULL],
];
$request_type = moduleHandler::validate($accepted_methods, $frontEndLogs);

if (!$request_type) {
  error_logs([MODULE, 'Invalid request method', __FILE__, __LINE__]);
  ApiResponse::Set(900000);
}
return $frontEndLogs->{$request_type}();
?>
