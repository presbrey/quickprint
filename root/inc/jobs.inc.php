<?php

require 'cview.lib.php';
$c = new cview();
$cj = $c->clusters_jobs();

?>
<div id="jobs">
<?php

foreach($cj as $cname=>$cprinters) {
	printf('<div id="c_%s" class="cjobs" onMouseOver="%s">',
			$cname,
			"highlightC('$cname')");
	foreach($cprinters as $pname=>$pjobs) {
		printf('%s: %s<br />', $pname, $pjobs);
	}
	echo '</div>';
}
?>
</div>
