<?php
use App\Auth\ModuleHandler;

require_once 'controller.php';
$appConfig = new AppConfig();

$accepted_methods = [
  'index'   => [false, NULL],
  'show'    => [true, [1, 2, 3]],
  'store'   => [true, [1, 2, 3]],
  'update'  => [true, [1, 2, 3]],
  'destroy' => [true, [1, 2, 3]],
];
ModuleHandler::Validate($accepted_methods, $appConfig);
?>
