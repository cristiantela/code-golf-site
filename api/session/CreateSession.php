<?php

function CreateSession ($link, $user) {
	include 'util/random.php';

	$token = random(40);

	$createSession = $link->prepare('
		INSERT INTO session
			(user, token)
		VALUES
			(:user, :token)
	');

	$result = $createSession->execute([
		'user' => $user,
		'token' => $token,
	]);

	if (!$result) {
		echo json_encode([
			'error' => 'Não foi possível inserir a nova sessão',
		]);
		exit();
	}

	echo json_encode([
		'token' => $token,
	]);
	exit();
}