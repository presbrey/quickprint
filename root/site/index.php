<?php

class Index extends QPPage {
	var $title = 'Start';
	function _default($argv) {
		$this->uName = $argv['uName'];
		include 'index.inc.php';
	}
	function jobs() {
		$q = $this->db->query(sprintf(DB_J_USER,$this->db->real_escape_string($this->uName)));
		while($row = $q->fetch_assoc())
			$res[] = $row;
		return $res;
	}
}

?>
