var lastCluster;

function cluster_hover(n) {
	if ($('b_'+lastCluster)) {
		$('b_'+lastCluster).className = 'cluster_b';
	}
	$('b_'+n).className += 'h';
	$('cluster_sel').innerHTML = 'map location: ' + n;
	lastCluster = n;
}
