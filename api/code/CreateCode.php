<?php

function CreateCode ($link, $data) {
	$user = $data['user'];
	$challenge = $data['challenge'];
	$language = $data['language'];
	$content = $data['content'];
	$length = $data['length'];

	$createCode = $link->prepare('
		INSERT INTO code
			(user, challenge, language, content, length)
		VALUES
			(:user, :challenge, :language, :content, :length)
	');

	$result = $createCode->execute([
		'user' => $user,
		'challenge' => $challenge,
		'language' => $language,
		'content' => $content,
		'length' => $length,
	]);

	if (!$result) {
		echo json_encode([
			'error' => 'Não foi possível inserir um novo código',
		]);
		exit();
	}

	$id = $link->lastInsertId();

	return [
		'id' => $id,
	];
}