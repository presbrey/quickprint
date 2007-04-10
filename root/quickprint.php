<?php
/* QuickPrint Site Object
 * 2007/04/09 Joe Presbrey <presbrey@mit.edu>
 */

require_once 'system.php';
require_once 'joe/util.lib.php';
require_once 'joe/site.lib.php';

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
		}
	}
}

class QPPage extends Page {
	function Start() {
		parent::Start();
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
