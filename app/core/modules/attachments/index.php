<?php
use App\Auth\ModuleHandler;

require_once __DIR__ . '/controller.php';
$attachs = new DocAttachments();

$accepted_methods = [
  //'index'   => [true, [1, 2, 3]],
  //'show'    => [true, [1, 2, 3]],
  'store'   => [false, NULL],
  //'update'  => [true, [1, 2, 3]],
  //'destroy' => [true, [1, 2, 3]],
];
ModuleHandler::Validate($accepted_methods, $attachs);
?>
