var lastCluster = "Barker";

function highlightC(n) {
	$('b_'+lastCluster).className = 'mapb';
	$('b_'+n).className += 'h';
	$('c_'+lastCluster).className = 'cjobs';
	$('c_'+n).className += 'h';
	lastCluster = n;
	$('c_selected').innerHTML = n;
}
