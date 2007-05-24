<?php

class User extends QPPage {
	var $title = 'Setup';
	var $handlers = array('post' => array('p_save'));
//						  'get'  => array('g_download', 'g_print', 'g_preview', 'g_setup','g_del'));

	function ipp_get_pass($user) {
		$pass = '';
		$q = $this->DB->query(sprintf(DB_A_GET,
			$this->DB->real_escape_string($this->s_uName)));
		while($row = $q->fetch_assoc()) {
			$res[] = $row;
		}
		if (isset($res) && count($res) == 1) {
			$res = $res[0];
			$pass = array_shift($res);
		}
		if (strlen($pass) == 0) {
			$pass = trim(exec(P_BIN.'nicepass'));
			User::ipp_set_pass($user, $pass);
		}
		return $pass;
	}

	function ipp_set_pass($user, $pass) {
		$q = $this->DB->prepare(DB_A_SET);
		$q->bind_param('sss', $user, $pass, $pass);
		$q->execute();
	}

	function p_save() {
		if (isset($this->s_uName) && isset($this->p_apass)) {
			if (str_repeat(' ',strlen($this->p_apass)) != $this->p_apass && strlen($this->p_apass)) {
				$this->ipp_set_pass($this->s_uName, $this->p_apass);
			}
		}
		header('Location: '.L_BASE);
		exit;
	}

	function _default() {
		include 'user.inc.php';
	}
}

?>
