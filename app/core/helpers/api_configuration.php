<?php
use App\Model\DBGet;

class ApiConfiguration {
	public function Get() {
		global $_apiConfig;
		$params = [
			'table' => 'config'
		];
		$config = new stdClass();
		$results = DBGet::Get($params, 'list');
		foreach($results as $entry) {
			$config->{$entry['slug']} = $entry['data'];
		}
		$_apiConfig = $config;
	}
}
$cnf = new ApiConfiguration();
$cnf->Get();
?>
