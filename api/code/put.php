<?php

function Put () {
	global $_PUT;

	$challenge = isset($_PUT['challenge']) ? $_PUT['challenge'] : '';
	$language = isset($_PUT['language']) ? $_PUT['language'] : '';
	$content = isset($_PUT['content']) ? $_PUT['content'] : '';
	$length = strlen($content);

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
		include 'code/CreateCode.php';
		$code = CreateCode($link, [
			'user' => $user,
			'challenge' => $challenge,
			'language' => $language,
			'content' => $content,
			'length' => $length,
		]);

		echo json_encode([
			'id' => $code['id'],
		]);
		exit();
	} else {
		include 'code/UpdateCode.php';
		UpdateCode($link, [
			'id' => $code['id'],
			'language' => $language,
			'content' => $content,
			'length' => $length,
		]);

		echo json_encode([
			'id' => $code['id'],
		]);
		exit();
	}
}