<?php
use App\Auth\ModuleHandler;

require_once __DIR__ . '/controller.php';
$inscriptions = new InscriptionsMailer();

$accepted_methods = [
  'store'   => [false, NULL],
];
ModuleHandler::Validate($accepted_methods, $inscriptions);

?>
