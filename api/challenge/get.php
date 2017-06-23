<?php

function Get () {
	include 'util/link.php';

	$link = Lin();

	$getChallenge = $link->prepare('
		SELECT id, user, title, description, start, finish
		FROM challenge
		WHERE
			NOW() >= start AND
			NOW() <= finish
	');

	$result = $getChallenge->execute();

	if (!$result) {
		echo json_encode([
			'error' => 'Não foi possível completar a consulta de desafio ativo',
		]);
		exit();
	}

	if ($getChallenge->rowCount() === 0) {
		echo json_encode([
			'error' => 'Nenhum desafio encontrado',
		]);
		exit();
	}

	$result = $getChallenge->fetch();

	echo json_encode([
		'id' => $result['id'],
		'user' => $result['user'],
		'title' => $result['title'],
		'description' => $result['description'],
		'start' => $result['start'],
		'finish' => $result['finish'],
	]);
	exit();
}