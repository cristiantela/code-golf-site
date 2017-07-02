<?php

function GetCodeRanking ($link, $data) {
	include_once('util/error.php');

	$challenge = isset($data['challenge']) ? $data['challenge'] : '';

	$get = $link->prepare('
		SELECT *
		FROM code
		WHERE
			challenge = :challenge
		ORDER BY
			length ASC
	');

	error($get->execute([
		'challenge' => $challenge,
	]), 'Erro ao tentar recuperar o ranking');

	$result = $get->fetchAll(PDO::FETCH_ASSOC);

	return $result;
}