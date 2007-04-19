<?php

function bytes_h($size) {
	$i=0; $iec = array("B", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB");
	while (($size/1024)>1) {
		$size=$size/1024;
		$i++;
	}
	return substr($size,0,strpos($size,'.')+2).$iec[$i];
}

?>