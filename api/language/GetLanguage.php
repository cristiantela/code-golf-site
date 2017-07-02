<?php

function GetLanguage ($link, $data) {
	include_once('util/error.php');

	$id = isset($data['id']) ? $data['id'] : '';

	$get = $link->prepare('
		SELECT *
		FROM language
		WHERE
			id = :id
	');

	error($get->execute([
		'id' => $id,
	]), 'Erro ao tentar recuperar a linguagem');

	$result = $get->fetch(PDO::FETCH_ASSOC);

	return $result;
}