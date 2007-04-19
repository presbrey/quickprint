<?php
/* QuickPrint Site Object
 * 2007/04/09 Joe Presbrey <presbrey@mit.edu>
 */

require_once 'system.php';
require_once 'joe/util.lib.php';
require_once 'joe/site.lib.php';
require_once 'sql.lib.php';
require_once 'filters.lib.php';

class QPSite extends Site {
	function Start() {
		if (isset($_GET['auth'])) {
			session_id($_GET['auth']);
			@session_start();
			session_regenerate_id();
			header(sprintf('Location: %s', L_BASE.newQSA(array('auth'=>null))));
			exit;
		} else {
			session_start();
			ob_start();
		}
		parent::Start();
	}
}

class QPPage extends Page {
	var $DB;
	function Start() {
		parent::Start();
		$this->DB = new mysqli('sql.mit.edu', DB_USER, DB_PASS, DB_NAME);
		if (!is_a($this, 'Error') &&
			(!isset($this->s_uName) || empty($this->s_uName))) {
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
	function error_item($item, $text) {
		$this->errors[$item] = $text;
	}
	function error($item) {
		if (isset($this->errors[$item])) {
			return sprintf('<span class="error_item">%s</span>', $this->errors[$item]);
		}
	}
	function has_errors() {
		return isset($this->errors) && count($this->errors);
	}
}

