<?php
class VTOToken extends VTO {
    public function __construct() 
    {
    	parent::__construct('token', 'igp_tokens', [
            'user' => ['user', 'userID', 'ID']
        ]);
    }
}
