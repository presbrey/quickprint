<?php

class Doc extends QPPage {
	var $title = 'Document';
	var $handlers = array('post' => array('add'));
	function add($argv) {
		$file = $argv['file'];

		//TODO: add type and size checks
		if (is_uploaded_file($file['tmp_name'])) {
			$finfo = new finfo();
			$jtype = $finfo->file($file['tmp_name']);

			$stmt = $this->db->prepare(DB_J_ADD);
			$stmt->bind_param('sssis', $argv['uName'], $file['name'], $file['tmp_name'], $file['size'], $jtype);
			$stmt->execute();
			$jid = $stmt->insert_id;

			$fname = P_JOBS.'/'.$jid.'_'.$argv['uName'];
			$stmt = $this->db->prepare(DB_J_MV);
			$stmt->bind_param('si', $fname, $jid);
			$stmt->execute();
			move_uploaded_file($file['tmp_name'], $fname);

			// send on to document options
			header('Location: '.L_BASE.'doc/'.$jid);
			exit;
		}
	}
}

?>
