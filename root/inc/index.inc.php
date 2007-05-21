<p>This tool helps you print documents to Athena cluster printers.  To print your documents, you must upload them to this server.</p><?/*  You can also schedule your documents to print later.</p>*/?>

<p><h2>Print New Document</h2></p>
<form action="doc" method="post" enctype="multipart/form-data">
<ol>
<p><li>Select a document to print from your computer: PDF, PostScript, or text:</li></p>
	<input type="hidden" name="MAX_FILE_SIZE" value="8388608" />
	<input type="file" name="file">
<p><li>Click the following button to upload the file you selected above:</li></p>
	<input type="submit" name="add" value="Upload Selected File">
</form>
</ol>

<hr />

<?php
	$jobs = $this->jobs($this->s_uName);
	if (count($jobs)) {
		foreach($jobs as $j)
			$jobs_by_state[$j['jstate']][] = $j;
?>

<p><h2>Manage Documents</h2></p>
<?php
	$manage_documents = false;
	if (isset($jobs_by_state['NEW'])) {
		$manage_documents = true;
		echo '<p><h3>New Documents</h3></p>';
		printf('<p>%s document%s ha%s been uploaded but not printed:</p>',
				count($jobs_by_state['NEW']==1) ? 'This' : 'These '.count($jobs_by_state['NEW']),
				count($jobs_by_state['NEW']==1) ? '' : 's',
				count($jobs_by_state['NEW']==1) ? 's' : 've');
		echo '<table id="docs_new" class="list" summary="New Documents">';
		echo '<tr><th scope="col">Document Name:</th><th scope="col">Printer</th><th scope="col">Date:</th><th colspan=4>Actions:</th></tr>';
		foreach($jobs_by_state['NEW'] as $job) {
			$jid = $job['jid'];
			$ext = strtolower(substr(strrchr($job['jname'], "."), 1));
			switch($ext) {
				case 'pdf': $img = 'acrobat.gif'; break;
				case 'ps': $img = 'script.gif'; break;
				default: $img = 'text.gif'; break;
			}
			echo '<tr>';
			printf('<td><a href="%sdoc/?download&jid=%d"><img src="%s" /> %s</a></td>',
					L_BASE, $job['jid'], L_IMG.$img, $job['jname']);
			if (empty($job['jqueue']))
				printf('<td><a href="%s">(select)</a></td>', L_BASE.'doc/?print&jid='.$jid);
			else
				printf('<td>%s</td>', $job['jqueue']);
			printf('<td>%s</td>', $job['dadded']);//, $job['jtype']);
			printf('<td><a href="%sdoc/?print&jid=%d"><img src="%s" /> Print</a></td>', L_BASE, $job['jid'], L_IMG.'news.gif');
			printf('<td><a href="%sdoc/?setup&jid=%d"><img src="%s" /> Options</a></td>', L_BASE, $job['jid'], L_IMG.'edit.gif');
			printf('<td><a href="%sdoc/?del&jid=%d"><img src="%s" /> Delete</a></td>', L_BASE, $job['jid'], L_IMG.'delete.png');
			echo '</tr>';
		}
		echo '</table>';
	}
?>
<? /* <p><h3>Queued</h3></p> */ ?>
<? /* <p><h2>Waiting Documents</h2></p> */ ?>
<?
	if (isset($jobs_by_state['DONE'])) {
		$manage_documents = true;
		echo '<p><h3>Printed Documents</h3></p>';
		echo '<table id="docs_done" class="list" summary="Printed Documents">';
		echo '<tr><th scope="col">Document Name:</th><th scope="col">Printer:</th><th scope="col">Date:</th><th scope="col" colspan=3>Actions:</th><th scope="col">Status:</th></tr>';
		foreach($jobs_by_state['DONE'] as $job) {
			$ext = strtolower(substr(strrchr($job['jname'], "."), 1));
			switch($ext) {
				case 'pdf': $img = 'acrobat.gif'; break;
				case 'ps': $img = 'script.gif'; break;
				default: $img = 'text.gif'; break;
			}
			echo '<tr>';
			printf('<td><a href="%sdoc/?download&jid=%d"><img src="%s" /> %s</a></td>',
					L_BASE, $job['jid'], L_IMG.$img, $job['jname']);
			if (empty($job['jqueue']))
				printf('<td><a href="%s">(select)</a></td>', L_BASE.'doc/?print&jid='.$jid);
			else
				printf('<td>%s</td>', $job['jqueue']);
			printf('<td>%s</td>', $job['dadded']);//, $job['jtype']);
			printf('<td><a href="%sdoc/?print&jid=%d"><img src="%s" /> Print</a></td>', L_BASE, $job['jid'], L_IMG.'news.gif');
			printf('<td><a href="%sdoc/?setup&jid=%d"><img src="%s" /> Options</a></td>', L_BASE, $job['jid'], L_IMG.'edit.gif');
			printf('<td><a href="%sdoc/?del&jid=%d"><img src="%s" /> Delete</a></td>', L_BASE, $job['jid'], L_IMG.'delete.png');
			strlen($job['jstatus']) && 	printf('<td>%s</td>', $job['jstatus']);
			echo '</tr>';
		}
		echo '</table>';
		printf('<p><img src="%s" /> %s</p>',
			L_IMG.'info.gif',
			'Documents can be reprinted, or downloaded by clicking their Name, and expire 3 days after their last print');
	}
	if (!$manage_documents) {
		echo '<p>Upload a document using the form above to start printing.</p>';
	}
	}
?>
