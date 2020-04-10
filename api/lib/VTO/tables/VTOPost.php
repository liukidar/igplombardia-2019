<?php
class VTOPost extends VTO {
    public function __construct() 
    {
    	parent::__construct('post', 'igp_posts', [
            'author' => ['authorid', 'user', 'id', 'LEFT']
        ]);
    }
}
