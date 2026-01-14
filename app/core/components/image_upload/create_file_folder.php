<?php
namespace App\Uploader;

abstract class CreateFileFolder {
	protected static function NewFolder($folder, $permissions) {
		if(!is_dir($folder)) {
			try {
				mkdir($folder, $permissions, TRUE);
			} catch(\Exception $e) {
				throw new \AppException('Could not create uploads foloder', 906003);
			}
		} elseif(!is_writable($folder)) {
			chmod($folder, $permissions);
		}
	}
}
?>
