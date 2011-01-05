<?php
/* Cluster Monitor Interface
 * 2007/02/13, Joe Presbrey <presbrey@mit.edu>
 */

class cview {
	private $socket = null;
	private $host = '';
	private $port = 3704;
	public function __construct() {
		$this->host = $this->_get_host();
	}
	private function _get_host() {
		$host = @dns_get_record('cview.sloc.ns.athena.mit.edu', DNS_TXT);
		if (is_array($host) && count($host)) {
			$host = array_pop($host);
			return $host['txt'];
		} else {
			return 'dill.mit.edu';
		}
	}
	private function commands($cmds=array()) {
		if ((is_string($cmds) && strlen($cmds) == 0) ||
			(is_array($cmds) && count($cmds) == 0)) {
				$cmds = array('help');
		} elseif (is_string($cmds)) {
			$cmds = array($cmds);
		}
		is_array($cmds) or trigger_error("cview error: invalid commands", E_USER_ERROR);

		$this->socket = @fsockopen($this->host, $this->port, $errno, $errstr, 30);
		if ($errno) {
			trigger_error(sprintf("cview error (%d): %s", $errno, $errstr), E_USER_WARNING);
		} else {
			@fwrite($this->socket, sprintf("%s\n", implode(' ', $cmds)));
			$buf = '';
			while($this->socket && !feof($this->socket))
				$buf .= @fgets($this->socket);
			@fclose($this->socket);
			return $buf;
		}
		return false;
	}
	private function _read_config() { return $this->commands('configplease3'); }
	private function _read_ints() { return $this->commands('intsonlyplease3'); }
	private function _parse_config() {
		$data = $this->_read_config();
		preg_match_all('/\d+\s+(.+)\n.*XXXXX\n.*\n(.*)XXXXX\n/U', $data, $m);
		if (count($m)==3 && count($m[1])>0 && count($m[2])>0) {
			$config = array();
			for($k = 0; $k < count($m[0]); $k++) {
				$config[] = array($m[1][$k], explode(' ',trim($m[2][$k])));
			}
			return $config;
		}
		return false;
	}
	private function _parse_ints() {
		$data = $this->_read_ints();
		preg_match_all('/printer\s(\w+)\s+(\w+)\s+(\d+)\n/U', $data, $m);
		if (count($m)==4 && count($m[1])>0 && count($m[2])>0 && count($m[3])>0) {
			$ints = array();
			for($k = 0; $k < count($m[0]); $k++) {
				$ints[] = array($m[1][$k], $m[2][$k], $m[3][$k]);
			}
			return $ints;
		}
		return false;
	}
	public function clusters_printers() {
		$data = $this->_parse_config();
		$clusters = array();
		foreach($data as $d) {
			if (isset($clusters[$d[0]])) {
				$clusters[$d[0]] = array_merge($clusters[$d[0]], $d[1]);
			} else {
				$clusters[$d[0]] = $d[1];
			}
		}
		return $clusters;
	}
	public function printers_clusters() {
		$data = $this->_parse_config();
		$printers = array();
		foreach($data as $d) {
			$printers2 = array();
			foreach($d[1] as $p) {
				$printers2[$p] = $d[0];
			}
			$printers = array_merge($printers, $printers2);
		}
		return $printers;
	}
	public function printers_jobs() {
		$data = $this->_parse_ints();
		$jobs = array();
		foreach($data as $d) {
			$jobs[$d[0]] = ($d[1] == 'up')?$d[2]:$d[1];
		}
		return $jobs;
	}
	public function clusters_jobs() {
		$data = array();
		$cprinters = $this->clusters_printers();
		$pjobs = $this->printers_jobs();
		foreach($cprinters as $cluster=>$printers) {
			foreach($printers as $printer) {
				$data[$cluster][$printer] = $pjobs[$printer];
			}
		}
		return $data;
	}
	public function printers() {
		$data = array();
		$printers = $this->printers_clusters();
		$pjobs = $this->printers_jobs();
		foreach($pjobs as $printer=>$jobs) {
			$data[$printer] = array('name'=>$printer, 'cluster'=>$printers[$printer], 'jobs'=>$jobs);
		}
		return $data;
	}
}

/* usage:
$cview = new cview();
var_dump($cview->printers());
*/
?>
