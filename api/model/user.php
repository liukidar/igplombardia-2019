<?php

require_once("../lib/lib.php");

class User
{
	private $VTM;
	private $validityTime;

	public function __construct($_VTM)
	{
		$this->VTM = $_VTM;
		$this->validityTime = 3600;
	}

	public function requestAuthToken($_mail, $_password)
	{
		$res = $this->VTM->get('user.requestAuthToken', [
			'fields' => ['id', 'mail', 'password', 'accessFlag', 'username'],
			'where' => 'mail = ?',
			'params' => [$_mail]
		]);
		while($user = $res->next()) {
			if(password_verify($_password, $user['password'])) {
				// Token granted
				$token = bin2hex(random_bytes(64));
				$this->VTM->post('token.set', [
						'fields' => ['token' => $token, 'userid' => $user['id'], 'ip' => $_SERVER['REMOTE_ADDR'], 'validity' => (time() + $this->validityTime)]
				]);

				setHeader('Auth-Token', $token);
				setData('user', ['id' => $user['id'], 'mail' => $user['mail'], 'username' => $user['username']]);

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
			'fields' => ['user.accessFlag', 'validity'],
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
					'fields' => ['validity' => (time() + 60)],
					'where' => 'token = ? AND ip = ?',
					'params' => [$_token, $_SERVER['REMOTE_ADDR']]
				]);

				// Create a new token
				$_token = bin2hex(random_bytes(64));
				$this->VTM->post('token.set', [
						'fields' => ['token' => $_token, 'userid' => $user['id'], 'ip' => $_SERVER['REMOTE_ADDR'], 'validity' => (time() + $this->validityTime)]
				]);

				setHeader('Auth-Token', $_token);
			}

			return $_user['user.accessFlag'];
		}

		pushError("INVALID_TOKEN");

		return false;
	}
}
