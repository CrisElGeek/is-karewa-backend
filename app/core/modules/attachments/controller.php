<?php
use App\Uploader\Images;
use App\Uploader\CreateFileFolder;
use \Gumlet\ImageResize;
use App\Validation\Files;
use App\Helpers\ApiResponse;

class DocAttachments extends CreateFileFolder {
  private array $config;

  function __construct() {
    if (isset($_FILES) && count($_FILES) > 0) {
      $this->request = $_FILES;
      $this->config   = [
        "folder"  => STATIC_PATH . STATIC_ATTACH_PATH,
				"path"    => STATIC_ATTACH_PATH,
        "permissions"  => 0777
      ];
    }
  }

  public function store() {
    try {
      Files::Validate($this->request, ["formats" => "(jpe?g|png|pdf)"]);
		} catch (\AppException $e) {
			ApiResponse::Set($e->errorCode());
    }
    $attach = [];
		foreach($this->request as $key => $file) {
			$fname = preg_replace('/([^a-zA-Z0-9\.\r]+)/', '-', $file['name']);
			try {
				$attach[] = self::uploadFile($file['tmp_name'], $fname, $key);
			} catch(\AppException $e) {
				ApiResponse::Set($e->errorCode());
			}
		}
		ApiResponse::Set('CREATED', [
			'data'  => [
        'url' => STATIC_URL,
				'files' => $attach
      ],
		]);
	}

	private function uploadFile($tmp, $fname, $key = 0) {
		$id = time() + $key;
		$static_path = $this->config['folder'] . $id ."/";
		$path = $this->config['path'] . $id ."/";
		parent::NewFolder($static_path, $this->config['permissions']);
		$upld = move_uploaded_file($tmp, $static_path . $fname);
		if(!$upld) {
			throw new \AppException('File fould not be updated', 906001);
		}
		return [
			'path' => $path,
			'id'	=> $id,
			'image' => $path . $fname,
			'name' => $fname
		];
	}
}
?>
