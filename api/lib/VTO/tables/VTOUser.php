<?php

class VTOUser extends VTO
{
	public function __construct() 
	{
		parent::__construct('user', 'igp_users', [], [
      'post' => ['post', ['get-on' => 'user.id = post.authorid', 'delete-on' => 'FALSE']]
    ]);
	}
}
