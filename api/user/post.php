<?php

function verifyIfDoesnotExistThisNumber ($link, $area, $ddd, $number) {
	$get = $link->prepare('
		SELECT id FROM user
		WHERE
			area = :area AND
			ddd = :ddd AND
			number = :number
	');

	$result = $get->execute([
		'area' => $area,
		'ddd' => $ddd,
		'number' => $number,
	]);

	if (!$result) {
		echo json_encode([
			'error' => 'Não foi possível completar a verificação de número'
		]);
		exit();
	}

	if ($get->rowCount() !== 0) {
		echo json_encode([
			'error' => 'Este número já está cadastrado no sistema',
		]);
		exit();
	}
}

function Post () {
	include 'util/random.php';

	$area = isset($_POST['area']) ? $_POST['area'] : '';
	$ddd = isset($_POST['ddd']) ? $_POST['ddd'] : '';
	$number = isset($_POST['number']) ? $_POST['number'] : '';
	$name = isset($_POST['name']) ? $_POST['name'] : '';
	$activation_code = random(8);

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

	verifyIfDoesnotExistThisNumber($link, $area, $ddd, $number);

	$createUser = $link->prepare('
		INSERT INTO user
			(area, ddd, number, name, activation_code)
		VALUES
			(:area, :ddd, :number, :name, :activation_code)
	');

	$result = $createUser->execute([
		'area' => $area,
		'ddd' => $ddd,
		'number' => $number,
		'name' => $name,
		'activation_code' => $activation_code,
	]);

	if (!$result) {
		echo json_encode([
			'error' => 'Não foi possível completar a inserção desse usuário'
		]);
		exit();
	}

	$id = $link->lastInsertId();

	echo json_encode([
		'id' => $id,
	]);
	exit();
}