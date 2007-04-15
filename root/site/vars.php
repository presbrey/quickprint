<?php

class Vars extends QPPage {
	var $title = 'Variables';
	function _default() {
		echo '<pre>';
		print_r(get_object_vars($this));
		print_r($GLOBALS);
	}
}

?>
