<?php
/* Cluster Map Demo
 * 2007/02/16 Joe Presbrey <presbrey@mit.edu>
 */

$map['1-142'] = array(200, 438);
$map['2-032'] = array(365, 360);
$map['2-225'] = array(360, 340);
$map['4-167'] = array(335, 345);
$map['12-182'] = array(280, 250);
$map['38-370'] = array(210, 167);
$map['56-129'] = array(375, 198);
$map['66-080'] = array(460, 175);
$map['Barker'] = array(230, 292);
$map['Bldg37'] = array(135, 200);
$map['E51-075'] = array(750, 220);
$map['Hayden'] = array(435, 345);
$map['Rotch'] = array(150, 320);
$map['W20'] = array(65, 340);
$mapname['Barker'] = 'Barker Library (10-6xx)';
$mapname['Bldg37'] = '37-312';
$mapname['Hayden'] = 'Hayden Library (14S-0xx)';
$mapname['Rotch'] = 'Rotch Library (7A-1xx)';
$mapname['W20'] = 'Student Center';

?>
<h2>Select a Cluster Location</h2>
<table id="clusters">
<form action="<?=L_BASE.'doc/?setup&jid='.$jid?>" method="post">
<tr>
<td valign="bottom"><span id="cluster_sel">&nbsp;</span></td>
<td valign="bottom" style="text-align:right">
<a id="unlisted_entry" class="unlisted" href="#" onClick="$('unlisted_entry').hide(); $('unlisted').show();">enter an unlisted queue</a>
<span id="unlisted" class="unlisted" style="display: none;">
enter an unlisted queue name: 
<input type="text" name="queue" size="12" />
<input type="submit" name="save" value="save" />
<input type="submit" name="print" value="print" />
</span>
</td></tr>
<tr><td colspan=2><div id="cluster_map">
<?
foreach($map as $name=>$pos) {
	$desc = isset($mapname[$name]) ? $mapname[$name] : NULL;
	$title = is_null($desc) ? sprintf("%s (%s)", $name, $desc) : $name;
	printf('<input alt="%s" type="button" class="cluster_b" style="left: %d; top: %d;" onMouseOver="%s" onClick="%s" id="%s" />',
			strlen($desc)?$desc:$name, $pos[0], $pos[1]-60,
			"cluster_hover('$name','$desc')",
			"location='$name/?jid=$jid';",
			'b_'.$name);
}
?>
<img src="<?=L_IMG?>map2.jpg" style="border: 1px solid black;" />
</div></td></tr>
</form>
<tr><td colspan=2>
<?php
printf('<span><img src="%s" /> %s</span>',
	L_IMG.'lightbulb.gif',
	'select a cluster on the map above denoted by its marker');
?></td></tr>
</table>
