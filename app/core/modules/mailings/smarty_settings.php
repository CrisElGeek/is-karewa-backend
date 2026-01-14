<?php
use Smarty;

function mailingSmarty($vars) {
	$smarty = new Smarty;
	$smarty->template_dir = ROOT_PATH . 'templates/views/';
	$smarty->compile_dir = ROOT_PATH . 'templates/views_c/';
	$smarty->cache_dir = ROOT_PATH . 'templates/cache/';
	$smarty->config_dir = ROOT_PATH . 'templates/configs/';
	$smarty->assign('name', 'Mailing template');
	foreach($vars as $key => $var) {
		$smarty->assign($key, $var);
	}
	$smarty->display('index.tpl');
}
?>
