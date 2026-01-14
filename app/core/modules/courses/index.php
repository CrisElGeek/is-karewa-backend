<?php
use App\Auth\ModuleHandler;

require_once __DIR__ . '/controller.php';
$courses = new CoursesComponent();

$accepted_methods = [
  'index'   => [false, NULL],
  'show'    => [false, NULL],
  'store'   => [true, [1, 2, 3]],
  'update'  => [true, [1, 2, 3]],
  'destroy' => [true, [1, 2, 3]],
];
ModuleHandler::Validate($accepted_methods, $courses);
?>
