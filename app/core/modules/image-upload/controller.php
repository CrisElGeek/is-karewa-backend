<?php
use App\Uploader\Images;
use \Gumlet\ImageResize;
use App\Validation\Files;
use App\Helpers\ApiResponse;

class ImageWidget {
  private array $config;

  function __construct() {
    if (isset($_FILES) && count($_FILES) > 0) {
      $this->request = $_FILES;
      $this->config   = [
        "folder"  => STATIC_PATH . STATIC_IMAGES_PATH,
				"path"    => STATIC_IMAGES_PATH,
				"quality"	=> 95,
        "permissions"  => 0777,
        "images"  => [
          "big" => [
            "sizes"   => [1600, 1600],
            "action"  => "resizeToBestFit"
          ],
          "medium" => [
            "sizes"   => [1080, 1080],
            "action"  => "resizeToBestFit"
          ],
          "small" => [
            "sizes"   => [640, 640],
            "action"  => "resizeToBestFit"
          ],
          "thumb" => [
            "sizes"   => [200, 200, true, ImageResize::CROPCENTER],
            "action"  => "crop"
          ],
          "pixel" => [
            "sizes"   => [75, 75],
            "action"  => "resizeToBestFit"
          ]
        ]
      ];
    }
  }

  public function store() {
    try {
      Files::Validate($this->request, ["formats" => "(jpe?g|png|gif)"]);
		} catch (\AppException $e) {
			ApiResponse::Set($e->errorCode());
    }
    $images = [];
		foreach($this->request as $key => $file) {
			$fname = preg_replace('/([^a-zA-Z0-9\.\r]+)/', '-', $file['name']);
			try {
				$images[] = Images::Save($this->config, $file['tmp_name'], $fname, (Int) $key);
			} catch(\AppException $e) {
				ApiResponse::Set($e->errorCode());
			}
		}
		ApiResponse::Set('CREATED', [
			'data'  => [
        'url' => STATIC_URL,
				'images' => $images
      ],
		]);
	}

  public function index() {
		try {
			$images = Images::Get();
		} catch(\AppException $e) {
			ApiResponse::Set($e->errorCode());
		}
		ApiResponse::Set('SUCCESS', [
      'data'  => [
        'url' => STATIC_URL,
      	'images' => $images
      ],
    ]);
  }

  public function show() {
		if(!is_numeric($_GET['id']) || !isset($_GET['id']) || $_GET['id'] < 1) {
			ApiResponse::Set(400002);
		}
		$id = trim(strip_tags($_GET['id']));
		try {
			$image = Images::Get($id);
		} catch(\AppException $e) {
			ApiResponse::Set($e->errorCode());
		}
		ApiResponse::Set('SUCCESS', [
      'data' => [
        'url'   => STATIC_URL,
        'image' => $image
      ]
    ]);
  }

	public function destroy() {
		if(!is_numeric($_GET['id']) || !isset($_GET['id']) || $_GET['id'] < 1) {
			ApiResponse::Set(400002);
		}
		$id = trim(strip_tags($_GET['id']));
    try {
      Images::Delete($id);
    }
		catch (\AppException $e) {
			ApiResponse::Set($e->errorCode());
    }
		ApiResponse::Set('DELETED');
  }
}
?>
