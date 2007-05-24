<?php

class FAQ extends QPPage {
	var $title = 'FAQ';
	function _default() {
		if (count($this->URI) == 2 || empty($this->URI[2])) {
			header('Location: '.L_BASE);
			exit;
		} else {
			$entry = $this->URI[2];
			include 'faq.inc.php';
		}
	}
}

?>
