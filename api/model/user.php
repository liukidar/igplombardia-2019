<?php

require_once("../lib.php");

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
			'fields' => ['id', 'mail', 'password'],
			'where' => 'mail = ?',
			'params' => [$mail]
		]);
		while($user = $res->next()) {
			if(password_verify($password, $user['password'])) {
				// Token granted
				$token = bin2hex(random_bytes(64));
				$this->VTM->post('authToken.set', [
						'fields' => ['token' => $token, 'user' => $user['id'], 'ip' => $_SERVER['REMOTE_ADDR'], 'validity' => (time() + $this->validityTime)]
				]);

				setHeader('authToken', $token);

				return true;
			}
		}

		pushMsg(ERROR, "USER_NOT_FOUND");

		return false;
	}

	public function clearAuthToken($_token)
	{
		$this->VTM->delete('authToken.delete', [
			'where' => 'token = ? OR validity < ?',
			'params' => [$_token, time()]
		]);

		setHeader('authToken', false);

		return;
	}

	public function checkAuthToken($_token)
	{
		if (!$_token) {
			pushMsg(ERROR, "NULL_TOKEN");

			return false;
		}

		$res = $this->VTM->get('authToken.check', [
			'fields' => ['user.accessFlag', 'validity'],
			'where' => 'token = ? AND ip = ?',
			'params' => [$_token, $_SERVER['REMOTE_ADDR']]
		]);
		
		if ($_user = $res->next()) {
			$validity = $_user['validity'] - time();
			if ($validity < 0) {
				pushMsg(ERROR, "EXPIRED_TOKEN");

				return false;
			}
			if ($validity < $validityTime / 2) {
				$this->VTM->put('authToken.update', [
					'fields' => ['validity' => (time() + $this->validityTime)],
					'where' => 'token = ? AND ip = ?',
					'params' => [$_token, $_SERVER['REMOTE_ADDR']]
				]);
			}

			return $_user['user.accessFlag'];
		}

		pushMsg(ERROR, "INVALID_TOKEN");

		return false;
	}
}
