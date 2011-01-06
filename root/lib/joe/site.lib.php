<?php
/* Generic Site Classes
 * 2007/04/09 Joe Presbrey <presbrey@mit.edu>
 */

class Site {
	var $URI, $ARGV;
	function __construct($uri) {
		$this->URI = $uri;
		$this->ARGV = array_merge(
			array_prepend_keys($_COOKIE,'c_'),
			array_prepend_keys($_FILES,'f_'),
			array_prepend_keys($_GET,'g_'),
			array_prepend_keys($_POST,'p_'));
	}
	function Start() {
		if (isset($_SESSION)) {
			$this->ARGV = array_merge(
				$this->ARGV,
				array_prepend_keys($_SESSION,'s_'));
		}
	}
	function Run($MODULE, $METHOD) {
		$nCalls = 0;
		if (file_exists(strtolower('site/'.$MODULE.'.php'))) {
			require_once strtolower('site/'.$MODULE.'.php');
			if (class_exists($MODULE)) {
				$page = new $MODULE($this, $METHOD);
				$page->Start();
				$handlers = array_intersect(
					$page->get_handlers($METHOD),
					array_keys($this->ARGV));
				foreach($handlers as $handler) {
					if (false !== $page->Run($handler)) {
						$nCalls++;
					}
				}
				if ($nCalls == 0 && is_callable(array($page, '_default'))) {
					$page->Run('_default');
					$nCalls++;
				}
				$page->Finish();
			}
		}
		return $nCalls;
	}
	function Finish() {}
}

class Page {
	var $SITE, $METHOD, $URI;
	function __construct($site, $method) {
		$this->SITE = $site;
		$this->METHOD = $method;
		foreach($site->ARGV as $k=>$v)
			$this->$k = $v;
		$this->URI = $site->URI;
	}
	function get_handlers() {
		$handlers = isset($this->handlers[$this->METHOD]) ?
					$this->handlers[$this->METHOD] : array();
		return $handlers;
	}
	function has_handler($handler) {
		return isset($this->handlers[$this->METHOD]) ?
				in_array($handler, $this->handlers[$this->METHOD]) : false;
	}

	function Start() {}
	function Run($handler) {
		if (is_callable(array($this, $handler))) {
			return array(0, call_user_func(array($this, $handler)));
		} else {
			return false;
		}
	}
	function Finish() {}
}
