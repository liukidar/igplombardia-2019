<?php

require_once("../lib/lib.php");

class User
{
	const VALIDITY_TIME = 3600;
	const PICTURE_DIR = 'profile_pics/';
	const CURRICULUM_DIR = 'profile_docs/';
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
			'fields' => ['id', 'mail', 'username', 'curriculum', 'picture', 'roles'],
			'where' => 'roles IS NOT NULL'
		]);

		$r = [];
		while ($user = $res->next()) {
			$user['curriculum'] = $this->remotePath . self::CURRICULUM_DIR . $user['curriculum'];
			$user['picture'] = $this->remotePath . self::PICTURE_DIR . $user['picture'];
			$user['roles'] = explode(';', $user['roles']);
			$r[] = $user;
		}

		setData('users', $r);

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
