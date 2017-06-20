<?php

function Get ($link) {
	$getUsers = $link->prepare('
		SELECT
			name, area, ddd, number, activation_code
		FROM user
		WHERE
			activation_code IS NOT NULL
		ORDER BY
			creation DESC
	');

	$result = $getUsers->execute();

	if (!$result) {
		echo json_encode([
			'error' => 'Não foi possível consultar usuários pré-cadastrados',
		]);
		exit();
	}

	$result = $getUsers->fetchAll();

	$return = [];
	foreach ($result as $value) {
		$return[] = [
			'name' => $value['name'],
			'area' => $value['area'],
			'ddd' => $value['ddd'],
			'number' => $value['number'],
			'activation_code' => $value['activation_code'],
		];
	}

	echo json_encode($return);
	exit();
}

function GetUsersPreRegistred () {
	include 'util/link.php';

	$link = Lin();

	include 'session/GetUserSessionByAuthorization.php';
	$user = GetUserSessionByAuthorization($link);

	if ($user) {
		include 'user/GetUserById.php';
		$user = GetUserById($link, $user);

		if ($user['paper'] != 5) {
			echo json_encode([
				'error' => 'Você não tem permissão de administrador para visualizar os membros pré-cadastrados'
			]);
			exit();
		}
	} else {
		echo json_encode([
			'error' => 'Nenhum usuário encontrado',
		]);
		exit();
	}

	Get($link);
}