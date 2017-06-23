<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	include 'challenge/post.php';
	Post();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
	include 'challenge/get.php';
	Get();
}