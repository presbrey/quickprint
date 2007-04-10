<?php

require_once 'system.php';
require_once 'joe/util.lib.php';

session_start();
$s_https = isset($_SERVER['HTTPS'])?$_SERVER['HTTPS']:0;
$s_uri = $_SERVER['REDIRECT_URL'];
if ($s_https) {
	$uGecos = $_SERVER['SSL_CLIENT_S_DN_CN'];
	$uEmail = $_SERVER['SSL_CLIENT_S_DN_Email'];
	$uName = array_shift(explode('@',$uEmail));
	$_SESSION['uGecos'] = $uGecos;
	$_SESSION['uEmail'] = $uEmail;
	$_SESSION['uName'] = $uName;
}

if (!empty($uName) && !empty($uEmail)) {
	$redir = str_replace(L_HOME.'/auth/', '', $s_uri).newQS('auth',session_id());
	header('Location: '.L_BASE.$redir);
	exit;
} else {
	header('Location: '.L_BASE.'error/cert');
	exit;
}
