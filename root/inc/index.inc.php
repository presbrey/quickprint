<p>QuickPrint helps you print documents on your computer to Athena cluster printers.</p>

<p><h2>Print New Document</h2></p>
<p>Select a file on your computer:
	<form action="doc" method="post" enctype="multipart/form-data">
	<input type="file" name="file">
	<input type="submit" name="add" value="Upload">
	</form>
</p>

<hr />

<?php
	$jobs = $this->jobs();
	foreach($jobs as $j) {
		$jobs_by_state[$j['jstate']][] = $j;
	}
?>

<p><h2>Manage Documents</h2></p>

<?php
	if (isset($jobs_by_state['NEW'])) {
		echo '<p><h3>New</h3></p>';
		echo '<table>';
		foreach($jobs_by_state['NEW'] as $job) {
			$ext = strtolower(substr(strrchr($job['jname'], "."), 1));
			switch($ext) {
				case 'pdf': $img = 'acrobat.gif'; break;
				case 'ps': $img = 'news.gif'; break;
				default: $img = 'text.gif'; break;
			}
			printf('<tr><td><img src="%s" />
						%s</td><td>%s</td><td>%s</td><td>%s</td>',
					L_IMG.$img,
					$job['jname'],
					$job['jsize'],
					$job['jtype'],
					$job['jstatus'],
					$job['jage']);
			printf('<td><a href="%sdoc/?del=%d">Delete</a></td>', L_BASE, $job['jid']);
			echo '</tr>';
		}
		echo '</table>';
	}
?>
<? /* <p><h3>Queued</h3></p> */ ?>
<? /* <p><h2>Waiting Documents</h2></p> */ ?>
<p><h3>Printed</h3></p>
