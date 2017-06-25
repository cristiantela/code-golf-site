<?php

function GetCodeByUserAndChallenge ($link, $user, $challenge) {
	$getCode = $link->prepare('
		SELECT id, user, challenge, language, content
		FROM code
		WHERE
			user = :user AND
			challenge = :challenge
	');

	$result = $getCode->execute([
		'user' => $user,
		'challenge' => $challenge,
	]);

	if (!$result) {
		echo json_encode([
			'error' => 'Não foi possível completar a consulta de visualicação do código por usuário e desafio',
		]);
		exit();
	}

	if ($getCode->rowCount() === 0) {
		return null;
	}

	$result = $getCode->fetch();

	return [
		'id' => $result['id'],
		'user' => $result['user'],
		'challenge' => $result['challenge'],
		'language' => $result['language'],
		'content' => $result['content'],
	];
}