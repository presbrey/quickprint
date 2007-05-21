var lastCluster;

function cluster_hover(n,d) {
	if ($('b_'+lastCluster)) {
		$('b_'+lastCluster).className = 'cluster_b';
	}
	$('b_'+n).className += 'h';
	if (d == null || !d.length) {
		$('cluster_sel').innerHTML = 'map location: ' + n;
	} else {
		$('cluster_sel').innerHTML = 'map location: ' + d;
	}
	lastCluster = n;
}
