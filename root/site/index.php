<?php

class Index extends QPPage {
	var $title = 'Start';
	function _default() {
		include 'index.inc.php';
	}
	function jobs() {
		$q = $this->DB->query(sprintf(DB_J_USER,$this->DB->real_escape_string($this->s_uName)));
		while($row = $q->fetch_assoc())
			$res[] = $row;
		return $res;
	}
}

?>
