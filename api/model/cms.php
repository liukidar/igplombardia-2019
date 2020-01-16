<?php

require_once("../lib/lib.php");

class CMS
{
	const PREVIEW_DIRS = [128 => 'previews128/', 256 => 'previews256/'];

  private $remotePath;
	private $localPath;
	private $allowedTypes;

  public function __construct($_remoteHost, $_localHost, $_path, $_allowedTypes)
  {
    $this->remotePath = $_remoteHost . $_path;
    $this->localPath = $_localHost . $_path;
		$this->allowedTypes = $_allowedTypes;
  }

  /**
   * Return all files in a directory, ordered by modify date
   * @param string target directory
   * @return array files
   */
  private function scanDirSorted($_dir)
  {
    $filenames = [];    
    foreach (scandir($_dir) as $filename) {
        if (!is_dir($_dir . $filename)) $filenames[$filename] = filemtime($_dir . '/' . $filename);
    }

    asort($filenames);
    $filenames = array_keys($filenames);

    return $filenames;
  }

  /**
   * Create an image preview of a file
   * @param string target file
   * @param string output directory
   * @param int output file resolution
   * @param int output file quality
   * @return bool result
   */
  private function createPreview($_file, $_dir, $_size = 256, $_quality = 85)
  {
    // Get file infos
    $info = getimagesize($_file);
    $name = basename($_file);

    // Create temproray preview from the file
    switch(strtolower($info['mime']))
    {
      case 'image/jpg':
      case 'image/jpeg':
        $tmp = imagecreatefromjpeg($_file);
        break;

      case 'image/png':
        $tmp = imagecreatefrompng($_file);
        break;

      case 'image/gif':
        $tmp = imagecreatefromgif($_file);
        break;
      
      default:
				return false;
    }

    // Calculate output resolution
    $ratio = $_size / max($_size, $info[0], $info[1]);
    $newWidth = $info[0] * $ratio;
    $newHeight = $info[1] * $ratio;

    // Create preview
    $preview = imagecreatetruecolor($newWidth, $newHeight);
		imagecopyresampled($preview, $tmp, 0, 0, 0, 0, $newWidth, $newHeight, $info[0], $info[1]);
		
    return imagejpeg($preview, $_dir.$name, $_quality);
  }

  public function list()
  {
    $r = [];
    $filenames = $this->scanDirSorted($this->localPath);

    foreach($filenames as $filename) {
			$src = $this->remotePath . $filename;
			$previews = [];
			foreach (self::PREVIEW_DIRS as $key => $previewDir) {
				if (file_exists($this->localPath . $previewDir . $filename)) {
					$previews[$key] = $this->remotePath . $previewDir . $filename;
				}
			}
      $r[] = [
        'id' => $filename,
        'src' => $src,
        'preview' => $previews
      ];
		}
		
		setData('files', $r);

    return;
  }

  public function create($_files, $_env, $_previews)
  {
    $r = [];
		$e = [];
		
    foreach ($_files as $file) {
      $filename = strtolower(date('Y-m-d') . '_' . $_env . '_' . $file['name']);
      $filename = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $filename);
      $filename = mb_ereg_replace("([\.]{2,})", '', $filename);

      if (!(in_array($file['type'], $this->allowedTypes))
      || !move_uploaded_file($file['tmp_name'], $this->localPath . $filename)) {
        $e[] = $filename;
      }
      else {
        $src = $this->remotePath . $filename;
				$previewSrcs = [];
				foreach ($_previews as $previewSize) {
					if (self::PREVIEW_DIRS[$previewSize]) {
						if ($this->createPreview($this->localPath . $filename, $this->localPath . self::PREVIEW_DIRS[$previewSize], $previewSize)) {
							$previewSrcs[$previewSize] = $this->remotePath . self::PREVIEW_DIRS[$previewSize] . $filename;
						}
						else {
							pushError('CANT_CREATE_PREVIEW');
						}
					}
					else {
						pushError('INVALID_PREVIEW_SIZE');
					}
				}
        $r[] = [
          'id' => $filename,
          'src' => $src,
          'preview' => $previewSrcs
        ];
      }
		}
		
		setData('files', $r);
		setData('errors', $e);

    return;
  }

  public function remove($_files)
  {
    $r = [];
    $e = [];

    foreach($_files as $filename) {
      if(unlink($this->localPath . $filename)) {
				foreach ($previews as $previewSize) {
					if (file_exists($this->localPath . self::PREVIEW_DIR[$previewSize] . $filename)) {
						unlink($this->localPath . self::PREVIEW_DIR[$previewSize] . $filename);
					}
				}
        $r[] = $filename;
      }
      else {
        $e[] = $filename;
      }
		}
		
		setData('files', $r);
		setData('errors', $e);

    return;
  }
}