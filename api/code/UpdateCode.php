<?php

function UpdateCode ($link, $data) {
	$id = $data['id'];
	$language = $data['language'];
	$content = $data['content'];
	$length = $data['length'];

	$updateCode = $link->prepare('
		UPDATE code
		SET
			language = :language,
			content = :content,
			length = :length
		WHERE
			id = :id
	');

	$result = $updateCode->execute([
		'id' => $id,
		'language' => $language,
		'content' => $content,
		'length' => $length,
	]);

	if (!$result) {
		echo json_encode([
			'error' => 'Não foi possível atualizar o novo código',
		]);
		exit();
	}

	return true;
}