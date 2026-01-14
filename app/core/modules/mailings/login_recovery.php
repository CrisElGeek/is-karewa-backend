<?php
use App\Helpers\ApiResponse;
require __DIR__ . '/smarty_settings.php';
class Mailings {
	function __construct() {
	}

	public function index() {
		global $smarty;
		if(!isset($_GET['recovery_hash'])) {
			error_logs([MODULE, 'No hash string provided', __LINE__, __FILE__]);
			ApiResponse::Set(909000);
		} elseif(!isset($_GET['role'])) {
			error_logs([MODULE, 'No user role provided', __LINE__, __FILE__]);
			ApiResponse::Set(909000);
		}
		$key = trim(strip_tags($_GET['recovery_hash']));
		$role = trim(strip_tags($_GET['role']));
		if(!is_numeric($role) || !in_array($role, [1,2,3,4,5])) {
			error_logs([MODULE, 'Invalid role id provided', __LINE__, __FILE__]);
			ApiResponse::Set(909000);
		}

		$url = SITE_URL . "/access/reset";
		if($role <= 3) {
			$url = CMS_URL . "/access/reset";
		}

		mailingSmarty([
			'code' => $_GET['code'],
			'login_recovery_link' => $url . "?h=" . $key,
			'template_body' => 'login_recovery.tpl'
		]);
	}
}
?>
