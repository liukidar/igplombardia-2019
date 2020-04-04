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

class User
{
	const VALIDITY_TIME = 3600;
	const PICTURE_DIR = 'profile_pics/';
	const CURRICULUM_DIR = 'profile_docs/';
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

	public function list()
	{
		$res = $this->VTM->get('user.list', [
			'fields' => ['id', 'mail', 'username', 'curriculum', 'picture', 'roles', 'qualifications', 'executive', 'designer', 'artisan', 'location']
		]);

		$r = [];
		while ($user = $res->next()) {
			$user['curriculum'] = $user['curriculum'] ? $this->remotePath . self::CURRICULUM_DIR . $user['curriculum']: null;
			$user['picture'] = $user['picture'] ? $this->remotePath . self::PICTURE_DIR . $user['picture'] : null;
			$user['roles'] = $user['roles'] ? explode(';', $user['roles']) : [];
			$user['qualifications'] = $user['qualifications'] ? explode(';', $user['qualifications']) : [];
			$r[] = $user;
		}

		setData('items', $r);

		return true;
	}

	public function create($_username, $_mail, $_roles, $_qualifications, $_location, $_files, $_types, $_access)
  {
		if (in_array($_files['type'][$i], self::ALLOWED_TYPES)) {
			if (move_uploaded_file($_files['tmp_name'][0], $this->localPath . $_files['name'][0])) {
				$password = random_str(6);
				$password_hash = password_hash($password, PASSWORD_DEFAULT);
				if ($this->VTM->post('user.create', [
					'fields' => ['password' => $password_hash, 'mail' => $_mail, 'username' => $_username, 'curriculum' => '', 'roles' => implode(';', $_roles), 'qualifications' => implode(';', $_qualifications),
						'executive' => $_types['executive'], 'designer' => $_types['designer'], 'artisan' => $_types['artisan'], 'location' => $_location, 'access' => implode('-', $_access)]
				])) {
					setData('item', ['id' => $this->VTM->last_inserted_id()]);
				}
			}
		}
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
				setData('user', ['id' => $user['id'], 'mail' => $user['mail'], 'username' => $user['username'], 'access' => flag2access($user['access'])]);

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

			$r = flag2access($_user['user.access']);

			return $r;
		}

		pushError("INVALID_TOKEN");

		return false;
	}
}
