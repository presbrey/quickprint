<?php

class Doc extends QPPage {
	var $title = 'Document';
	var $handlers = array('post' => array('p_add'),
						  'get'  => array('g_del'));
	function p_add() {
		$file = $this->f_file;

		//TODO: add type and size checks
		if (is_uploaded_file($file['tmp_name'])) {
			$finfo = new finfo();
			$jtype = $finfo->file($file['tmp_name']);

			$stmt = $this->db->prepare(DB_J_ADD);
			$stmt->bind_param('sssis', $this->s_uName, $file['name'], $file['tmp_name'], $file['size'], $jtype);
			$stmt->execute();
			$jid = $stmt->insert_id;

			$fname = P_JOBS.'/'.$jid.'_'.$this->s_uName;
			$stmt = $this->db->prepare(DB_J_MV);
			$stmt->bind_param('si', $fname, $jid);
			$stmt->execute();
			move_uploaded_file($file['tmp_name'], $fname);

			// send on to document options
			//header('Location: '.L_BASE.'doc/'.$jid);

			// send on to document print
			header('Location: '.L_BASE.'print/'.$jid);

			exit;
		}
	}
	function g_del() {
		if (strlen($this->g_del) && strlen($this->s_uName)) {
			$stmt = $this->db->prepare(DB_J_RM);
			$stmt->bind_param('is', $this->g_del, $this->s_uName);
			$stmt->execute();

			// send back to index
			header('Location: '.L_BASE);
			exit;
		}
	}
}

?>
