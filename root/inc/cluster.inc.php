<p><h2>Select a Cluster Printer: <?=$name?></h2></p>
<p>The cluster has the following printers.  You should select a printer with few jobs for fastest printing.</p>
<?php

echo '<form method="post" action="'.L_BASE.'doc/?jid='.$jid.'">';
echo '<table id="printers" class="list" summary="Cluster Printer List">';
echo '<tr><th></th><th scope="col">Printer Name:</th><th scope="col">Jobs:</th></tr>';
foreach($cluster as $printer=>$jobs) {
	if($printer=='bw') {
		$printer_label = 'bw (Pharos hold-and-release, aka mitprint)';
	} else {
		$printer_label = $printer;
	}
	printf('<tr onMouseOver="$(\'%s\').activate();" onClick="$(\'%s\').checked=true">', $printer, $printer);
	printf('<td><input type="radio" id="%s" name="queue" value="%s" /></td>', $printer, $printer);
	printf('<td><label for="%s" id="%s">%s</td><td style="text-align: right;">%d</td>', $printer, $printer, $printer_label, $jobs);
	echo '</tr>';
}
echo '</table><p>';
echo '<input type="submit" name="print" value="Print Now" />';
echo '<input type="submit" name="save" value="Print Later" />';
printf('<input type="button" value="Back to Clusters" onClick="location=\'../?jid=%d\';" />', $jid);
echo '</p></form>';
