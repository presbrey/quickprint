<?php

class Error extends QPPage {
	var $title = 'Error';
	function _default($argv) {
		if (count($this->argp) == 0 || empty($this->argp[0])) {
			header('Location: '.L_BASE);
			exit;
		} else {
			$error = $this->argp[0];
			include 'error.inc.php';
		}
	}
}

?>
