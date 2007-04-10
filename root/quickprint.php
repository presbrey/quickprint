<?php
/* QuickPrint Site Object
 * 2007/04/09 Joe Presbrey <presbrey@mit.edu>
 */

require_once 'system.php';
require_once 'joe/util.lib.php';
require_once 'joe/site.lib.php';
require_once 'sql.lib.php';

class QPSite extends Site {
	function Start() {
		if (isset($_GET['auth'])) {
			session_id($_GET['auth']);
			@session_start();
			session_regenerate_id();
			header(sprintf('Location: %s', newQSA(array('auth'=>null))));
			exit;
		} else {
			session_start();
			ob_start();
		}
	}
}

class QPPage extends Page {
	var $db;
	function Start() {
		parent::Start();
		$this->db = new mysqli('sql.mit.edu', DB_USER, DB_PASS, DB_NAME);
		if (!is_a($this, 'Error') &&
			(!isset($_SESSION['uName']) ||
			 empty($_SESSION['uName']))) {
			header('Location: '.L_HTTPS.'/auth'.$_SERVER['REQUEST_URI']);
			exit;
		}
		$this->Head();
	}
	function Finish() {
		$this->Foot();
		parent::Finish();
	}
	function Head() {
		include 'head.inc.php';
		include 'menu.inc.php';
	}
	function Foot() {
		include 'foot.inc.php';
	}
}
