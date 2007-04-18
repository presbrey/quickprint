<?php

class Error extends QPPage {
	var $title = 'Error';
	function _default() {
		if (count($this->URI) == 2 || empty($this->URI[2])) {
			header('Location: '.L_BASE);
			exit;
		} else {
			$error = $this->URI[2];
			include 'error.inc.php';
		}
	}
}

?>
