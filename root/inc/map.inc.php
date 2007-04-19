<?php
/* Cluster Map Demo
 * 2007/02/16 Joe Presbrey <presbrey@mit.edu>
 */

$map['W20'] = array(65, 340);
$map['Bldg37'] = array(135, 200);
$map['38-370'] = array(210, 160);
$map['Rotch'] = array(160, 320);
$map['66-080'] = array(445, 170);
$map['56-129'] = array(380, 190);
$map['4-167'] = array(345, 345);
$map['2-225'] = array(360, 340);
$map['2-032'] = array(370, 355);
$map['1-142'] = array(200, 430);
$map['Barker'] = array(230, 275);
$map['12-182'] = array(280, 250);
$map['E51-075'] = array(750, 220);
$map['Hayden'] = array(435, 345);

?>
<h2>Select a Cluster Location<h2>
<table id="clusters">
<tr><td align="right"><span id="cluster_sel">&nbsp;</span></td></tr>
<tr><td><div id="cluster_map">
<?
foreach($map as $name=>$pos) {
	printf('<input type="button" class="cluster_b" style="left: %d; top: %d;" onMouseOver="%s" onClick="%s" id="%s" />',
			$pos[0], $pos[1],
			"cluster_hover('$name')",
			"location='$name/?jid=$jid';",
			'b_'.$name);
}
?>
<img src="<?=L_IMG?>map.jpg" style="border: 1px solid black;" />
</div></td></tr>
<tr><td>
<form action="<?=L_BASE.'doc/?setup&jid='.$jid?>" method="post">
<p style="float:right;">
<a id="unlisted_entry" class="expert" href="#" onClick="$('unlisted_entry').hide(); $('unlisted').show();">expert mode</a>
<span id="unlisted" class="expert" style="display: none;">
enter an unlisted print queue: 
<input type="text" name="queue" size="12" />
<input type="submit" name="save" value="save" />
<input type="submit" name="print" value="print" />
</span>
</p>
</form>
<?php
printf('<p><img src="%s" /> %s</p>',
	L_IMG.'lightbulb.gif',
	'select a cluster above denoted by its green marker');
?></td></tr>
</table>
