<?php
use App\Auth\ModuleHandler;

require_once __DIR__ . '/controller.php';
$users = new Users();

$accepted_methods = [
  'index'   => [true, [1, 2, 3]],
  'show'    => [true, [1, 2, 3, 4, 5], ['hash' => true]],
  'store'   => [false, NULL],
  'update'  => [true, [1, 2, 3, 4, 5]],
  'destroy' => [true, [1, 2, 3]],
];
ModuleHandler::Validate($accepted_methods, $users);
?>
