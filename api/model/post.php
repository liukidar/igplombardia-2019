<?php

require_once("../lib/lib.php");

class Post
{
	const PICTURE_DIR = 'post_pics/';
  const ALLOWED_TYPES = ['image/png', 'image/jpg', 'image/jpeg'];
	private $VTM;
  private $remotePath;
	private $localPath;

	public function __construct($_VTM, $_remoteHost, $_localHost, $_path)
	{
		$this->VTM = $_VTM;
		$this->remotePath = $_remoteHost . $_path;
    $this->localPath = $_localHost . $_path;
  }

  public function row2el(&$_row) {
    $_row['picture'] = $_row['picture'] ? $this->remotePath . self::PICTURE_DIR . $_row['picture'] : null;

    return $_row;
  }

  public function el2row($_el, $_fields) {
    $row = [];

    foreach ($_fields as $field) {
      $row[$field] = $_el[$field];
    }

    if (isset($row['picture'])) {
      $row['picture'] = str_replace($this->remotePath . self::PICTURE_DIR, '', $row['picture']);
    }

    return $row;
  }
  
  public function list()
	{
		$res = $this->VTM->get('post.list', [
			'fields' => ['id', 'title', 'link', 'authorid', 'location', 'picture', 'author.username' => 'author', 'author.id' => 'authorid', 'author.qualifications' => 'qualifications']
		]);

		$r = [];
		while ($row = $res->next()) {
			$r[] = $this->row2el($row);
		}

		setData('items', $r);

		return true;
  }
  
  public function create($_el, $_picture)
  {
    $row = $this->el2row($_el, ['title', 'link', 'authorid', 'location', 'picture']);

		if ($_picture && in_array($_picture['type'], self::ALLOWED_TYPES)) {
      $r = move_uploaded_file($_picture['tmp_name'], $this->localPath . self::PICTURE_DIR . $_picture['name']);
      if ($r == false) {
        return false;
      } else {
        $_el['picture'] = $this->remotePath . self::PICTURE_DIR . $_el['picture'];
      }
    }
    if ($this->VTM->post('post.create', [
      'fields' => $row
    ])) {
      $_el['id'] = $this->VTM->last_inserted_id();
      setData('items', [$_el]);

      return true;
    }

    return false;
  }
  
  public function edit($_el, $_picture)
  {
    $row = $this->el2row($_el, ['title', 'link', 'authorid', 'location', 'picture']);

    if ($_picture && in_array($_picture['type'], self::ALLOWED_TYPES)) {
      $r = $this->VTM->get('post.get', ['fields' => ['picture'], 'where' => 'id = ?', 'params' => [$_el['id']]]);
      $previous_picture = $r->next()['picture'];
      if ($previous_picture) {
        unlink($this->localPath.self::PICTURE_DIR.$previous_picture);
      }
      $r = move_uploaded_file($_picture['tmp_name'], $this->localPath . self::PICTURE_DIR . $_picture['name']);
      if ($r == false) {
        return false;
      } else {
        $_el['picture'] = $this->remotePath . self::PICTURE_DIR . $_el['picture'];
      }
    }

    $r = $this->VTM->put('post.edit', [
      'fields' => $row,
      'where' => 'id = ?',
      'params' => [$_el['id']]
    ]);

    setData('item', $_el);

    return true;
  }

  public function remove($_id)
  {
    $r = $this->VTM->delete('post.delete', [
      'where' => 'id = ?',
      'params' => [$_id]
    ]);
    if ($r == false) {
      return false;
    }

    setData('id', $_id);

    return true;
  }
}