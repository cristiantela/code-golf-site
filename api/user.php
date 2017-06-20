<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

	if (isset($_GET['type'])) {
		$type = $_GET['type'];

		if ($type === 'pre registred') {
			include 'user/GetUsersPreRegistred.php';
			GetUsersPreRegistred();
		}
	} else {
		include 'user/get.php';
		Get();
	}
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
	include 'user/post.php';
	Post();
}