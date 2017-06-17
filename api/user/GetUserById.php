<?php

function GetUserById ($link, $user) {
	$getUserPaper = $link->prepare('
		SELECT name, paper FROM user
		WHERE
			id = :user
	');

	$result = $getUserPaper->execute([
		'user' => $user,
	]);

	if (!$result) {
		echo json_encode([
			'error' => 'Não foi possível completar a consulta de visualicação do papel de usuário',
		]);
		exit();
	}

	if ($getUserPaper->rowCount() === 0) {
		echo json_encode([
			'error' => 'Usuário não encontrado',
		]);
		exit();
	}

	$result = $getUserPaper->fetch();

	return [
		'id' => $user,
		'name' => $result['name'],
		'paper' => $result['paper'],
	];
}