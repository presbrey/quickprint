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
<div id="map">
<?
foreach($map as $name=>$pos) {
	printf('<input type="button" class="mapb" style="left: %d; top: %d;" onMouseOver="%s" onClick="%s" id="%s" />',
			$pos[0], $pos[1],
			"highlightC('$name')",
			"alert('You selected: $name\\n\\nQuickPrint is coming soon!')",
			'b_'.$name);
}
?>
<img src="img/map.jpg" style="border: 1px solid black;" />
<br />
<center><span id="c_selected"></span></center>
</div>
