<?php

require_once("../lib/lib.php");

class Post
{
	const PICTURE_DIR = 'post_pics/';
	private $VTM;
  private $remotePath;
	private $localPath;

	public function __construct($_VTM, $_remoteHost, $_localHost, $_path)
	{
		$this->VTM = $_VTM;
		$this->remotePath = $_remoteHost . $_path;
    $this->localPath = $_localHost . $_path;
  }
  
  public function list()
	{
		$res = $this->VTM->get('post.list', [
			'fields' => ['id', 'title', 'link', 'authorid', 'location', 'picture', 'author.username' => 'username', 'author.qualifications' => 'qualifications']
		]);

		$r = [];
		while ($post = $res->next()) {
			$post['picture'] = $this->remotePath . self::PICTURE_DIR . $post['picture'];
			$r[] = $post;
		}

		setData('items', $r);

		return true;
	}
}