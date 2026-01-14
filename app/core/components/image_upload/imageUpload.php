<?php
namespace App\Uploader;
use Gumlet\ImageResize;

abstract class Images extends CreateFileFolder {

  static public function Save(Array $config, String $img, String $name, Int $key = 0) {
		$id = time() + $key;
    $relative_path = $config['folder'] . $id . '/';
		parent::NewFolder($relative_path, $config['permissions']);
    $url = $config['path'] . $id . '/';

    $images = [
      'id'   => $id,
      'path' => $url,
      'name' => $name,
    ];

    foreach ($config['images'] as $key => $resize) {
      $image = new ImageResize($img);
      $folder = self::createFolder($key, $resize);
      $dir    = ROOT_DIR . $relative_path . $folder;
      $addr   = $url . $folder;
      call_user_func_array([$image, $resize['action']], $resize['sizes']);

			if (!is_dir($dir)) {
				try {
        	mkdir($dir, $config['permissions'], TRUE);
				} catch(\Exception $e) {
				throw new \AppException('Could not create uploads foloder', 906003);
			}
      }

      $images['sizes'][$key] = $addr . $name;
			$image->quality_jpg = $config['quality'];
			$image->save($dir . $name);
    }
    return $images;
  }

  static private function createFolder($name, $resize) {
    $path = $name . '/';
    foreach ($resize['sizes'] as $key => $size) {
      if (is_numeric($size) && $key < 2) {
        $path .= $size . '_';
      }
    }
    return trim($path, '_') . '/';
  }

	static public function Get($id = NULL) {
		if($id && $id > 0) {
			return self::getById($id);
		} else {
			$files = glob(STATIC_PATH . STATIC_IMAGES_PATH . '*', GLOB_ONLYDIR);
			if(count($files) == 0) {
				throw new \AppException('No fils found', 404000);
			}
			$list  = [];
			foreach ($files as $value) {
				$name = basename($value);
				$xxxx = glob($value . '/*');
				foreach ($xxxx as $vname) {
					$action = basename($vname);
					$f      = glob($vname . '/*/*');
					foreach ($f as $kfile => $file) {
						if ($kfile == 0) {
							$n = $file;
						}
						$yyyy[$action] = STATIC_IMAGES_PATH . preg_replace('#' . STATIC_PATH . STATIC_IMAGES_PATH . '#', '', $file);
					}
				}
				$list[] = [
					'id'    => (int) $name,
					'name'  => end(explode('/', $n)),
					'path'  => STATIC_IMAGES_PATH . $name . '/',
					'sizes' => $yyyy,
				];
			}
			return $list;
		}
  }

  static private function getById($id) {
    $list = [];
		$dir  = STATIC_PATH . STATIC_IMAGES_PATH . $id;
		$f    = glob($dir . '/*', GLOB_ONLYDIR);
		if(count($f) == 0) {
			throw new \AppException("No file found with id ", 404000);
		}
		foreach ($f as $file) {
			$files = glob($file . '*/*/*');
      $name  = basename($file);
      foreach ($files as $key => $value) {
        if ($key == 0) {
          $n = $value;
        }
        $yyyy[$name] = preg_replace('#' . STATIC_PATH . '#', '', $value);
      }
    }

    $list = [
      'id'     => (int) $id,
      'name'   => end(explode('/', $n)),
      'path'   => STATIC_IMAGES_PATH . $id . '/',
      'sizes' => $yyyy,
    ];
    return $list;
  }

  static public function Delete(int $id) {
    $directory = STATIC_PATH . STATIC_IMAGES_PATH . $id;
    if (!is_dir($directory)) {
      throw new \AppException('This folder does not exist', 909000);
    } else {
      $delete = true;
      $dirs   = glob($directory . '/*', GLOB_ONLYDIR);
      foreach ($dirs as $dir) {
        $folders = glob($dir . '/*', GLOB_ONLYDIR);
        foreach ($folders as $folder) {
          $files = glob($folder . '/*');
          foreach ($files as $file) {
            if (!unlink($file)) {
              $delete = false;
            };
          }
          if (!rmdir($folder)) {
            $delete = false;
          }
        }
        if (!rmdir($dir)) {
          $delete = false;
        }
      }
      if (!rmdir($directory)) {
        $delete = false;
      }
      if (!$delete) {
        throw new \AppException('This file can not be deleted', 909000);
      } else {
        return true;
      }
    }
  }
}
?>
