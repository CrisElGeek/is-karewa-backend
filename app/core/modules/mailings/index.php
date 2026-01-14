<?php
use App\Helpers\ApiResponse;
use App\Auth\ModuleHandler;

$mailings = [
	'login-recovery' => [
		'params' => [
			$_GET['code']
		],
		'file' => 'login_recovery.php'
	]
];

$uri = trim(strip_tags($_GET['s']));
$options = $mailings[$uri];

$template_component = __DIR__ . '/' . $options['file'];
if(!file_exists($template_component)) {
	ApiResponse::Set(404000);
}
require $template_component;

$mailings = new Mailings();

$accepted_methods = [
	'index' => [false, NULL, ['hash' => $_GET["_key"]]]
];

header("Content-Type: text/html");
ModuleHandler::Validate($accepted_methods, $mailings);
?>
