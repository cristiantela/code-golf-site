<?php

function Get () {
	$challenge = isset($_GET['challenge']) ? $_GET['challenge'] : '';

	include 'util/link.php';
	$link = Lin();

	include 'session/GetUserSessionByAuthorization.php';
	$user = GetUserSessionByAuthorization($link);

	if (!$user) {
		echo json_encode([
			'error' => 'Você precisa estar conectado para realizar esta ação',
		]);
		exit();
	}

	include 'code/GetCodeByUserAndChallenge.php';
	$code = GetCodeByUserAndChallenge($link, $user, $challenge);

	if ($code === null) {
		echo json_encode([
			'language' => '',
			'content' => '',
		]);
		exit();
	} else {
		echo json_encode([
			'language' => $code['language'],
			'content' => $code['content'],
		]);
		exit();
	}
}