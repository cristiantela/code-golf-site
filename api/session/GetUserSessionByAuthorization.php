<?php

function GetUserSessionByAuthorization ($link) {
	$headers = getallheaders();

	$token = isset($headers['Authorization']) ? $headers['Authorization'] : '';

	if (empty($token)) {
		return null;
	}

	$getSession = $link->prepare('
		SELECT user
		FROM session
		WHERE
			token = :token
	');

	$result = $getSession->execute([
		'token' => $token,
	]);

	if (!$result) {
		echo json_encode([
			'error' => 'Não foi possível completar a verificação de token',
		]);
		exit();
	}

	if ($getSession->rowCount() === 0) {
		return null;
	} else {
		return $getSession->fetch()['user'];
	}
}