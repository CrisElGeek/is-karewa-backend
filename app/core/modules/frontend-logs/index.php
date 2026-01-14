<?php
use App\Auth\moduleHandler;

require_once 'controller.php';
$frontEndLogs = new FrontendLogs($request);

$accepted_methods = [
  'store'   => [false, NULL],
];
$request_type = moduleHandler::validate($accepted_methods, $frontEndLogs);

return $frontEndLogs->$request_type();
?>
