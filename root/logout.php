<?php

require_once 'system.php';

@session_start();
session_destroy();
if (isset($_SERVER['HTTP_REFERER'])) {
	header('Location: '.$_SERVER['HTTP_REFERER']);
	exit;
} else {
	header('Location: '.L_BASE);
	exit;
}

?>
