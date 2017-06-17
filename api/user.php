<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	include 'user/get.php';
	Get();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
	include 'user/post.php';
	Post();
}