<?php

class Queues extends QPPage {
	var $title = 'Queues';
//	var $handlers = array('post' => array('p_add', 'p_setup', 'g_setup'),
//						  'get'  => array('g_download', 'g_print', 'g_preview', 'g_setup','g_del'));
	function _default() {
		if (count($this->URI)<3 || empty($this->URI[2])) {
			$this->show_map();
		} else {
			$this->show_cluster($this->URI[2]);
		}
	}

	function show_map() {
		if (isset($this->g_jid) && strlen($this->g_jid)) {
			$jid = $this->g_jid;
			include 'map.inc.php';
		} else {
			header('Location: '.L_BASE);
			exit;
		}
	}

	function show_cluster($name) {
		if (isset($this->g_jid) && strlen($this->g_jid)) {
			$jid = $this->g_jid;
		}
		require 'cview.lib.php';
		$c = new cview();
		$cj = $c->clusters_jobs();
		if (isset($cj[$name])) {
			$cluster = $cj[$name];
			include 'cluster.inc.php';
		} else {
			header('Location: '.L_BASE);
			exit;
		}
	}
    function queues_recent($user) {
        $q = $this->DB->query(sprintf(DB_JQ_RECENT,
            $this->DB->real_escape_string($user)));
        while($row = $q->fetch_row()) {
            $res[] = $row;
        }
        if (isset($res))
            return $res;
    }
}

?>
