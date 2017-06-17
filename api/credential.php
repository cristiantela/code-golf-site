<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	include 'credential/post.php';
	Post();
}