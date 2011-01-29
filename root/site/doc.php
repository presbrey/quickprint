<?php

class Doc extends QPPage {
	var $title = 'Document';
	var $handlers = array('post' => array('p_add', 'p_setup', 'p_queue', 'g_setup', 'p_print', 'p_preview'),
						  'get'  => array('g_queue', 'g_download', 'g_print', 'g_preview', 'g_setup','g_del'));

	function p_add() {
		$file = $this->f_file;
		if (isset($file['error']) && $file['error']>0) {
			switch($file['error']) {
				case 1:
					header('Location: '.L_BASE.'error/upload_max');
					exit;
				case 3:
					header('Location: '.L_BASE.'error/upload_part');
					//exit;
				case 4:
					header('Location: '.L_BASE.'error/upload_empty');
					exit;
				case 7:
					header('Location: '.L_BASE.'error/upload_disk');
					exit;
			}
		}

		if (is_uploaded_file($file['tmp_name'])) {
			$finfo = new finfo();
			$jtype = $finfo->file($file['tmp_name']);

			$stmt = $this->DB->prepare(DB_J_ADD);
			$stmt->bind_param('sssis', $this->s_uName, $file['name'], $file['tmp_name'], $file['size'], $jtype);
			$stmt->execute();
			$jid = $stmt->insert_id;

			$fname = P_JOBS.'/'.$this->s_uName.'_'.$jid;
			$stmt = $this->DB->prepare(DB_J_MV);
			$stmt->bind_param('si', $fname, $jid);
			$stmt->execute();
			move_uploaded_file($file['tmp_name'], $fname);

			header('Location: '.L_BASE.'doc/?setup&jid='.$jid);

			exit;
		}
	}

	function p_setup() {
		if (strlen($this->g_jid)) {
			$jid = $this->g_jid;
			$this->p_jnup = 1;
			//$this->p_jnup = intval($this->p_jnup);
			$this->p_jduplex = intval($this->p_jduplex);
			if (!in_array($this->p_jnup, array(1,2,4))) { $this->error_item('jnup', 'Multiple pages per sheet: must be 1, 2, or 4'); }
			//if ($this->p_jduplex < 0 || $this->p_jduplex > 1) {
			//	$this->error_item('jduplex', 'Duplex printing: invalid selection'); return;
			//}
			if (intval($this->p_jcopies) != $this->p_jcopies) { $this->error_item('jcopies', 'Copies: must be a number'); }
			if ($this->p_textnup < 0 || $this->p_textnup > 9) { $this->error_item('textnup', 'Pages per sheet: must be 1 or 2'); }
			if ($this->p_textln < 0) { $this->error_item('textln', 'Line numbering: must 0 or more (0=disable)'); }
			if (!in_array($this->p_texthon, array(0,1))) { $this->error_item('texthon', 'Disable headers and footers: must be Yes or No'); }
			if (!in_array($this->p_textbon, array(0,1))) { $this->error_item('textbon', 'Disable column borders: must be Yes or No'); }
			if (isset($this->p_schedule) && !empty($this->p_schedule)) { $this->error_item('schedule', 'Scheduling doesn\'t work yet.  Try again later.'); }
			if (!$this->has_errors()) {
				$q = $this->DB->prepare(DB_JO_SET);
				$q->bind_param('iiiiis', $this->p_jnup, $this->p_jbanner, $this->p_jcopies, $this->p_jduplex, $jid, $this->s_uName);
				$q->execute();
				if ($this->get_job_mode($this->get_job($jid, $this->s_uName)) == 'text') {
					$q = $this->DB->prepare(DB_JT_SET);
					$q->bind_param('iiiisssssssis', intval($this->p_textnup), intval($this->p_textln), intval($this->p_texthon), intval($this->p_textbon),
						$this->p_texth, $this->p_textlt, $this->p_textct, $this->p_textrt, $this->p_textlf, $this->p_textcf, $this->p_textrf,
						$jid, $this->s_uName);
					$q->execute();
				}
				if (isset($this->p_save)) {
					header('Location: '.L_BASE);
					exit;
				}
			}
		}
	}

	function p_queue() {
		if (strlen($this->g_jid)) {
			$jid = $this->g_jid;
			if ($this->p_queue == 'select') {
				header('Location: '.L_BASE.'queues/?jid='.$jid);
				exit;
			} else {
				$queue = $this->p_queue;
				//while (substr($queue, -1, 1) == '2')
				//	$queue = substr($queue, 0, -1);
				if (strlen($queue)) {
					$q = $this->DB->prepare(DB_J_SETQ);
					$q->bind_param('sis', $queue, $jid, $this->s_uName);
					$q->execute();
					if (isset($this->p_save)) {
						header('Location: '.L_BASE);
						exit;
					}
				}
			}
		} else {
			header('Location: '.L_BASE);
			exit;
		}
	}

    function g_queue() {
        $this->p_queue = $this->g_queue;
        $this->p_save = $this->g_save;
        $this->p_queue();
    }

	function p_select() {
		if (strlen($this->g_jid)) {
			$jid = $this->g_jid;
		}
		header('Location: '.L_BASE);
		exit;
	}

	function g_download() {
		if (strlen($this->g_jid)) {
			ob_clean();
			$jid = $this->g_jid;
			$q = $this->DB->query(sprintf(DB_J_GET,
				$this->DB->real_escape_string($jid),
				$this->DB->real_escape_string($this->s_uName)));
			while($row = $q->fetch_assoc()) {
				$res[] = $row;
			}
			if (count($res) == 1) {
				$res = $res[0];
				if (!is_null($res['jfile']) && file_exists($res['jfile'])) {
					$finfo = new finfo(FILEINFO_MIME, '/usr/share/file/magic');
					if ($finfo) {
						$ctype = $finfo->file($res['jfile']);
						$ctype = 'Content-type: '.$ctype;
					} else {
						$ctype = 'Content-type: application/octet-stream';
					}
					$ctype .= sprintf('; name="%s"', $res['jname']);
					header($ctype);
					header(sprintf('Content-Disposition: attachment; filename="%s"', $res['jname']));
					readfile($res['jfile']);
					exit;
				}
			}
		}
		header('Location: '.L_BASE);
		exit;
	}

	function queue($jid, $juser) {
		$job = $this->get_job($jid, $juser);
		if ($job) {
			$jbanner = ($job['jbanner'] == 1) ? '' : '-o job-sheets=none';
			//$t_ban = ($jbanner ? $this->make_banner($job) : '');
			$t_doc = $this->make_printable($job);
			clearstatcache();
			//if (file_exists($t_doc) && filesize($t_doc) && (!$jbanner || (file_exists($t_ban) && filesize($t_ban)>0))) {
			if (file_exists($t_doc) && filesize($t_doc)) {
				$qdest = $job['jqueue'];
				$qcopies = $job['jcopies'];
                if (intval($qcopies) < 1)
                    $qcopies = 1;
                $jdup = $job['jduplex']!=0?'-o sides=two-sided-long-edge':'-o sides=one-sided';
				$qname = basename($job['jfile']);
				//`/mit/quickprint/ID/renew`;
				//putenv('KRB5CCNAME=/tmp/krb5cc_536886204');

				$t_err = tempnam('/tmp', 'qpe_');
				if (filesize($t_doc)>0) {
                    `/usr/bin/lpr.cups -H printers.mit.edu -U$juser -P$qdest -J$qname -#$qcopies $jdup $jbanner $t_doc >$t_err 2>&1`;
                    $lpr_err = trim(file_get_contents($t_err));
					if (strlen($lpr_err)==0) {
                        $q = $this->DB->prepare(DB_S_ADD);
                        $q->bind_param('isi', $jid, $job['jqueue'], $m[1][0]);
                        $q->execute();
                        $q = $this->DB->prepare(DB_J_STATUS);
                        $q->bind_param('sis', strval(sprintf("Printed to %s, %s", $job['jqueue'], date("M j G:i:s T Y"))), $jid, $this->s_uName);
                        $q->execute();
					} else {
                        $q = $this->DB->prepare("INSERT INTO joberr (jid,jerr,derr) VALUES (?,?,NOW())");
                        $q->bind_param('is', $jid, $lpr_err);
                        $q->execute();
						$q = $this->DB->prepare(DB_J_STATUS);
						$q->bind_param('sis', strval(sprintf("Error printing to %s at %s: %s", $job['jqueue'], date("M j G:i:s T Y"), $lpr_err)), $jid, $this->s_uName);
						$q->execute();
					}
				} else {
					$q = $this->DB->prepare(DB_J_STATUS);
					$q->bind_param('sis', strval(sprintf("Error converting document to postscript, %s", $job['jqueue'], date("M j G:i:s T Y"))), $jid, $this->s_uName);
					$q->execute();
                    $q = $this->DB->prepare("INSERT INTO joberr (jid,jerr,derr) VALUES (?,?,NOW())");
                    $q->bind_param('is', $jid, trim(file_get_contents($t_err)));
                    $q->execute();
				}

				//if (strlen($t_ban))
				//	@unlink($t_ban);
                if (substr($t_doc, 0, 4) == '/tmp')
                    @unlink($t_doc);
				@unlink($t_err);
			}
		}
		header('Location: '.L_BASE);
		exit;
	}

	function g_print() {
		if (strlen($this->g_jid)) {
			$jid = $this->g_jid;
			$job = $this->get_job($jid, $this->s_uName);
			if (empty($job['jqueue'])) {
				header('Location: '.L_BASE.'queues/?jid='.$jid);
				exit;
			} else {
				$q = $this->DB->prepare(DB_J_STATE);
				$q->bind_param('sis', strval('DONE'), $jid, $this->s_uName);
				$q->execute();
				$this->queue($jid, $this->s_uName);
			}
		}
	}
	function p_print() { $this->g_print(); }

	function g_preview() {
		if (isset($this->g_jid) && strlen($this->g_jid)) {
			ob_clean();
			$jid = $this->g_jid;
			$job = $this->get_job($jid, $this->s_uName);
			$t_doc = $this->make_printable($job);
			if (strlen($t_doc) && file_exists($t_doc)) {
				header('Content-type: application/pdf');
				header(sprintf('Content-Disposition: attachment; filename="%s-%d.pdf"', $this->s_uName, time()));
				ob_end_flush();
				$t_err = tempnam('/tmp', 'qpe_');
				$t_out = tempnam('/tmp', 'qp_');
				`gs -q -dBATCH -dSAFER -dNOPAUSE -dQUIET -sDEVICE=pdfwrite -sOutputFile=$t_out $t_doc 2> $t_err`;
				if (strlen(trim(file_get_contents($t_err)))>0) {
					`gs -q -dBATCH -dSAFER -dNOPAUSE -dQUIET -sDEVICE=pdfwrite -dDOINTERPOLATE -r300 -sOutputFile=$t_out $t_doc 2> $t_err`;
					if (strlen(trim(file_get_contents($t_err)))==0) {
						readfile($t_out);
					} else {
						readfile($t_err);
					}
				} else {
					readfile($t_out);
				}
				@unlink($t_err);
                if (substr($t_doc, 0, 4) == '/tmp')
                    @unlink($t_doc);
				@unlink($t_out);
				exit;
			}
		}
		header('Location: '.L_BASE);
		exit;
	}
	function p_preview() { $this->g_preview(); }

	function g_setup() {
		if (strlen($this->g_jid)) {
			$jid = $this->g_jid;

			$job = $this->get_job($jid, $this->s_uName);
			if ($job) {
				$job_edit = true;
				if (is_null($job['jnup'])) {
					$job_edit = false; // new
					$q = $this->DB->prepare(DB_JO_ADD);
					$q->bind_param('is', $jid, $this->s_uName);
					$q->execute();
					$job = $this->get_job($jid, $this->s_uName);
					$job['texth'] = $this->s_uGecos;
				}
				foreach ($job as $k=>$v) {
					$prop = 'p_'.$k;
					if (isset($this->$prop) && array_key_exists($k, $job))
						$job[$k] = $this->$prop;
				}
				if ($this->get_job_mode($job) == 'raw') {
					$this->error_item('jtype', 'Document is not compatible (PDF, PostScript, or text).  It is strongly recommended you Preview the document before printing.');
				}
				include 'doc.inc.php';
			} else {
				header('Location: '.L_BASE);
				exit;
			}
		}
	}

	function g_del() {
        if (strlen($this->g_jid)) {
			$jid = $this->g_jid;
            $stmt = $this->DB->prepare(DB_J_RM);
            $stmt->bind_param('is', $jid, $this->s_uName);
            $stmt->execute();

            // send back to index
            header('Location: '.L_BASE);
            exit;
        }
	}

	function get_job($jid, $juser) {
		$q = $this->DB->query(sprintf(DB_JO_GET,
			$this->DB->real_escape_string($jid),
			$this->DB->real_escape_string($juser)));
		while($row = $q->fetch_assoc()) { $res[] = $row; }
		if (count($res) == 1) { return $res[0]; }
		return false;
	}

	function get_job_mode($job) {
		$jmode = 'raw';
		stristr($job['jtype'], 'text') && $jmode = 'text';
		stristr($job['jtype'], 'postscript') && $jmode = 'ps';
		stristr($job['jtype'], 'pdf') && $jmode = 'pdf';
		return $jmode;
	}

	function make_banner($res) {
		$t_pre = tempnam('/tmp', 'qp_');
		rename($t_pre, "$t_pre.ps");
		$t_pre = "$t_pre.ps";

		$x_ban = sprintf('(%sbanner -n %s -J %s -P %s %s) | psset -q -s - > %s',
			P_FILTERS,
			escapeshellarg($res['juser']),
			escapeshellarg($res['jname']),
			escapeshellarg($res['jqueue']),
			$res['jduplex'] != 0 ? '; echo showpage' : '',
			$t_pre);
		`$x_ban`;

		return $t_pre;
	}

	function get_printable($jid, $juser) {
		$job = $this->get_job($jid, $juser);
		if ($job) { return $this->make_printable($job); }
	}

	function make_printable($res) {
		$jfile = $res['jfile'];

		$t_pre = tempnam('/tmp', 'qp_');
		rename($t_pre, "$t_pre.ps");
		$t_pre = "$t_pre.ps";

		switch($this->get_job_mode($res)) {
			case 'text':
				$x_a2ps = 'a2ps --medium=Letter';
				$x_a2ps .= " -{$res['textnup']}";
				if ($res['texthon']==1) {
					$a2ps['-b'] = strlen($res['texth']) ? $res['texth'] : '';
					$a2ps['--left-footer='] = strlen(trim($res['textlf'])) ? $res['textlf'] : NULL;
					$a2ps['--footer='] = strlen($res['textcf']) ? $res['textcf'] : '';
					$a2ps['--right-footer='] = strlen($res['textrf']) ? $res['textrf'] : NULL;
					$a2ps['--left-title='] = strlen($res['textlt']) ? $res['textlt'] : '';
					$a2ps['--center-title='] = strlen($res['textct']) ? trim($res['textct']) : '';
					$a2ps['--right-title='] = strlen($res['textrt']) ? $res['textrt'] : '';
					foreach($a2ps as $k=>$v) {
						if (!is_null($v))
							$x_a2ps .= ' '.$k.escapeshellarg($v);
					}
				} else {
					$x_a2ps .= ' -B';
				}
				if ($res['textbon']==0) $x_a2ps .= ' --borders=no';
				if ($res['textln']>0) $x_a2ps .= ' --line-numbers='.intval($res['textln']);
				$x_a2ps .= " -o$t_pre $jfile";
				`$x_a2ps`;
				break;

            case 'pdf':
                `pdf2ps $jfile $t_pre`;
                break;

			default:
				//copy($jfile, $t_pre);
                `sed -E 's:/(Duplex|Tumble) (false|true) *::g' $jfile > $t_pre`;
				break;
		}
		return $t_pre;
	}

}

?>
