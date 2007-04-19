<p><h2>Select a Cluster Printer: <?=$name?></h2></p>
<p>The cluster has the following printers.  You should select a printer with few jobs for fastest printing.</p>
<?php

echo '<form method="post" action="'.L_BASE.'doc/?jid='.$jid.'">';
echo '<table id="printers" class="list">';
echo '<tr><td></td><th>Printer Name:</th><th>Jobs:</th></tr>';
foreach($cluster as $printer=>$jobs) {
	printf('<tr onMouseOver="$(\'%s\').activate();" onClick="$(\'%s\').checked=true">', $printer, $printer);
	printf('<td><input type="radio" id="%s" name="queue" value="%s" /></td>', $printer, $printer);
	printf('<td>%s</td><td style="text-align: right;">%d</td>', $printer, $jobs);
	echo '</tr>';
}
echo '</table><p>';
echo '<input type="submit" name="print" value="Print Now" />';
echo '<input type="submit" name="save" value="Print Later" />';
printf('<input type="button" value="Back to Clusters" onClick="location=\'../?jid=%d\';" />', $jid);
echo '</p></form>';
