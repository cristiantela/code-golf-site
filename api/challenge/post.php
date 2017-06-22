<?php

function Post () {
	$title = isset($_POST['title']) ? $_POST['title'] : '';
	$description = isset($_POST['description']) ? $_POST['description'] : '';
	$start = isset($_POST['start']) ? $_POST['start'] : '0000-00-00 00:00:00';
	$finish = isset($_POST['finish']) ? $_POST['finish'] : '0000-00-00 00:00:00';

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

	include 'user/GetUserById.php';
	$user = GetUserById($link, $user);

	if ($user['paper'] != 5) {
		echo json_encode([
			'error' => 'Você precisa ser um administrador para realizar esta ação',
		]);
		exit();
	}

	$createChallenge = $link->prepare('
		INSERT INTO challenge
			(user, title, description, start, finish)
		VALUES
			(:user, :title, :description, :start, :finish)
	');

	$result = $createChallenge->execute([
		'user' => $user['id'],
		'title' => $title,
		'description' => $description,
		'start' => $start,
		'finish' => $finish,
	]);

	if (!$result) {
		echo json_encode([
			'error' => 'Não foi possível completar a inserção desse desafio'
		]);
		exit();
	}

	$id = $link->lastInsertId();
	
	echo json_encode([
		'id' => $id,
	]);
	exit();
}