<?php

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
	include 'util/put.php';
	parsePut();

	include 'code/put.php';
	Put();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
	include 'code/get.php';
	Get();
}