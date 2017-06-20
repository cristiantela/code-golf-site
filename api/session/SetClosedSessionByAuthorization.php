<?php

function SetClosedSessionByAuthorization ($link) {
	$headers = getallheaders();

	$token = isset($headers['Authorization']) ? $headers['Authorization'] : '';

	if (empty($token)) {
		return null;
	}

	$getSession = $link->prepare('
		UPDATE session
		SET
			is_open = false
		WHERE
			token = :token AND
			is_open = true
	');

	$result = $getSession->execute([
		'token' => $token,
	]);

	if (!$result) {
		echo json_encode([
			'error' => 'Não foi possível completar a cancelação de token',
		]);
		exit();
	}

	if ($getSession->rowCount() === 0) {
		echo json_encode([
			'error' => 'Nada foi alterado',
		]);
		exit();
	} else {
		echo json_encode([
			'token' => '',
		]);
		exit();
	}
}