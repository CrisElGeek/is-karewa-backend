<?php
use App\Auth\ModuleHandler;

require_once __DIR__ . '/controller.php';
$roles = new Roles();

$accepted_methods = [
  'index'   => [true, [1, 2, 3]],
  'show'    => [true, [1, 2, 3]],
  'store'   => [true, [1]],
  'update'  => [true, [1]],
  'destroy' => [true, [1]],
];
ModuleHandler::Validate($accepted_methods, $roles);

?>
