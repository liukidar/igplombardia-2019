<?php

require_once("../lib/lib.php");

function random_str(
	$length,
	$keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
) {
	$str = '';
	$max = mb_strlen($keyspace, '8bit') - 1;
	if ($max < 1) {
			throw new Exception('$keyspace must be at least two characters long');
	}
	for ($i = 0; $i < $length; ++$i) {
			$str .= $keyspace[random_int(0, $max)];
	}
	return $str;
}

function flag2dict($_string, $_flags, $_sep = '-') {
  $r = array_fill_keys($_flags, false);
  if (strlen($_string)) {
    foreach (explode($_sep, $_string) as $flag) {
      $r[$flag] = true;
    }
  }

  return $r;
}

function dict2Flag($_dict, $_flags, $_sep = '-') {
  $r = [];
  foreach ($_flags as $flag) {
    if ($_dict[$flag] == true) {
      $r[] = $flag;
    }
  }

  return count($r) ? join($_sep, $r) : '';
}

class User
{
	const VALIDITY_TIME = 3600;
	const PICTURE_DIR = 'profile_pics/';
	const CURRICULUM_DIR = 'profile_docs/';
  const ALLOWED_TYPES = ['image/png', 'image/jpg', 'image/jpeg'];
  const USER_TYPES = ['a', 'e', 'd'];
  const USER_FLAGS = ['v', 'c', 'e', 'd', 'su'];
	private $VTM;
  private $remotePath;
	private $localPath;

	public function __construct($_VTM, $_remoteHost = NULL, $_localHost = NULL, $_path = NULL)
	{
		$this->VTM = $_VTM;
		$this->remotePath = $_remoteHost . $_path;
    $this->localPath = $_localHost . $_path;
  }
  
  public function row2el(&$_row) {
    $_row['curriculum'] = $_row['curriculum'] ? $this->remotePath . self::CURRICULUM_DIR . $_row['curriculum'] : '';
    $_row['picture'] = $_row['picture'] ? $this->remotePath . self::PICTURE_DIR . $_row['picture'] : '';
    $_row['types'] = flag2dict($_row['types'], self::USER_TYPES);
    $_row['access'] = flag2dict($_row['access'], self::USER_FLAGS);
    $_row['roles'] = $_row['roles'] ? explode(';', $_row['roles']) : '';
    $_row['qualifications'] = $_row['qualifications'] ? explode(';', $_row['qualifications']) : '';

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
    if (isset($row['roles'])) {
      $row['roles'] = implode(';', $row['roles']);
    }
    if (isset($row['qualifications'])) {
      $row['qualifications'] = implode(';', $row['qualifications']);
    }
    if (isset($row['types'])) {
      $row['types'] = dict2Flag($row['types'], self::USER_TYPES);
    }
    if (isset($row['access'])) {
      $row['access'] = dict2Flag($row['access'], self::USER_FLAGS);
    }

    return $row;
  }

	public function list()
	{
    // Access flag is public, don't think it really matters here.
		$res = $this->VTM->get('user.list', [
			'fields' => ['id', 'mail', 'username', 'curriculum', 'picture', 'roles', 'qualifications', 'types', 'location', 'access']
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
    $row = $this->el2row($_el, ['mail', 'username', 'curriculum', 'roles', 'qualifications', 'types', 'location', 'access', 'picture']);

		if ($_picture && in_array($_picture['type'], self::ALLOWED_TYPES)) {
      $r = move_uploaded_file($_picture['tmp_name'], $this->localPath . self::PICTURE_DIR . $_picture['name']);
      if ($r == false) {
        return false;
      } else {
        $_el['picture'] = $this->remotePath . self::PICTURE_DIR . $_el['picture'];
      }
    }
    if ($this->VTM->post('user.create', [
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
    $row = $this->el2row($_el, ['mail', 'username', 'roles', 'qualifications', 'types', 'location', 'access', 'picture']);

    if ($_picture && in_array($_picture['type'], self::ALLOWED_TYPES)) {
      $r = $this->VTM->get('user.get', ['fields' => ['picture'], 'where' => 'id = ?', 'params' => [$_el['id']]]);
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

    $r = $this->VTM->put('user.edit', [
      'fields' => $row,
      'where' => 'id = ?',
      'params' => [$_el['id']]
    ]);

    setData('item', $_el);

    return true;
  }

  public function remove($_id)
  {
    $r = $this->VTM->delete('user.delete', [
      'where' => 'id = ?',
      'params' => [$_id]
    ]);
    if ($r == false) {
      return false;
    }

    setData('id', $_id);

    return true;
  }

	public function requestAuthToken($_mail, $_password)
	{
		$res = $this->VTM->get('user.requestAuthToken', [
			'fields' => ['id', 'mail', 'password', 'access', 'username'],
			'where' => 'mail = ?',
			'params' => [$_mail]
    ]);
		while($user = $res->next()) {
			if(password_verify($_password, $user['password'])) {
				// Token granted
				$token = bin2hex(random_bytes(64));
				$this->VTM->post('token.set', [
						'fields' => ['token' => $token, 'userid' => $user['id'], 'ip' => $_SERVER['REMOTE_ADDR'], 'validity' => (time() + self::VALIDITY_TIME)]
				]);

				setHeader(AUTH_TOKEN, $token);
				setData('user', ['id' => $user['id'], 'mail' => $user['mail'], 'username' => $user['username'], 'access' => flag2dict($user['access'], ACCESS_FLAGS)]);

				return true;
			}
		}

		pushError("INVALID_CREDENTIALS");

		return false;
	}

	public function clearAuthToken($_token)
	{
		$this->VTM->delete('token.delete', [
			'where' => 'token = ? OR validity < ?',
			'params' => [$_token, time()]
		]);

		setHeader('Auth-Token', '');

		return;
	}

	public function checkAuthToken($_token)
	{
		if (!$_token) {
			pushError("NULL_TOKEN");

			return false;
		}

		$res = $this->VTM->get('token.check', [
			'fields' => ['user.access', 'validity'],
			'where' => 'token = ? AND ip = ?',
			'params' => [$_token, $_SERVER['REMOTE_ADDR']]
		]);
		
		if ($_user = $res->next()) {
			$validity = $_user['validity'] - time();
			if ($validity < 0) {
				pushError("EXPIRED_TOKEN");

				return false;
			}
			if ($validity < $validityTime / 2) {
				// Set validity of current token to 1 min
				$this->VTM->put('token.update', [
					'fields' => ['validity' => (time() + 16)],
					'where' => 'token = ? AND ip = ?',
					'params' => [$_token, $_SERVER['REMOTE_ADDR']]
				]);

				// Create a new token
				$_token = bin2hex(random_bytes(64));
				$this->VTM->post('token.set', [
						'fields' => ['token' => $_token, 'userid' => $user['id'], 'ip' => $_SERVER['REMOTE_ADDR'], 'validity' => (time() + self::VALIDITY_TIME)]
				]);

				setHeader('Auth-Token', $_token);
			}

			$r = flag2dict($_user['user.access'], ACCESS_FLAGS);

			return $r;
		}

		pushError("INVALID_TOKEN");

		return false;
	}
}
