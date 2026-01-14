<?php
namespace App\Validation;
class Files {
	private array $phpFileUploadErrors = [
		0 => [],
		1 => [
			"text"  => 'The uploaded file exceeds the UPLOAD_MAX_FILESIZE directive specified by the server',
			"code"  => 906000
		],
		2 => [
			"text"  => 'The uploaded file exceeds the MAX_FILE_SIZE directive specified by the server',
			"code"  => 906000
		],
		3 => [
			"text"  => 'The uploaded file was only partially uploaded',
			"code"  => 906001
		],
		4 => [
			"text"  => 'No file was uploaded',
			"code"  => 906001
		],
		6 => [
			"text"  => 'Missing a temporary folder',
			"code"  => 909000
		],
		7 => [
			"text"  => 'Failed to write file to disk.',
			"code"  => 909000
		],
		8 => [
			"text"  => 'A PHP extension stopped the file upload.',
			"code"  => 909000
		]
	];
  public static function Validate(array $files, array $params) {
    foreach($files as $file) {
      $errorKey = $file["error"];
      if($errorKey != 0) {
        throw new \AppException($this->phpFileUploadErrors[$errorKey]["text"], $this->phpFileUploadErrors[$errorKey]["code"]);
      } elseif(!preg_match("#" .$params["formats"] ."#", $file["type"])) {
        throw new \AppException("Invalid file format", 906002);
      }
		}
		return true;
  }
}
?>
