<?php
/*
    (c) 2005 Joe Presbrey
    joepresbrey@gmail.com
*/

function build_str($query_array) {
    $query_string = array();
    foreach ($query_array as $k => $v) {
        $new = $k;
        if (strlen($v))
            $new .= '='.$v;
        $query_string[] = $new;
    }
    return join('&', $query_string);
}

function newQS($key, $val=null) {
    return newQSA(array($key=>$val));
}

function newQSA($array=array()) {
    parse_str($_SERVER['QUERY_STRING'], $arr);
    $s = count($arr);
    foreach($array as $key=>$val) {
        $arr[$key] = $val;
        if (is_null($val))
            unset($arr[$key]);
    }
    return (count($arr)||$s)?'?'.build_str($arr):'';
}

function array_prepend_keys($lst, $pre) {
	if (is_array($lst) && count($lst) && is_string($pre)) {
		$rlst = array_combine(array_map(create_function('$a','return "'.$pre.'$a";'),array_keys($lst)),$lst);
		if (is_array($rlst) && count($rlst)) {
			return $rlst;
		}
	}
	return $lst;
}

?>
