<?
/* Request Dispatch
 * 2007/02/16 Joe Presbrey <presbrey@mit.edu>
 */

require_once('system.php');

$euri = explode('/', $_SERVER['REDIRECT_URL']);
if (count($euri)<2 || empty($euri[1]))
	$euri = array('', 'index');
$etest = sprintf('%s%s.php', P_INC, $euri[1]);
if (file_exists($etest) && is_file($etest)) {
	include $etest;
} else {
	if (strlen($_SERVER['QUERY_STRING']))
		header('Location: ' . L_BASE.'?'.$_SERVER['QUERY_STRING']);
	else
		header('Location: ' . L_BASE);
	exit;
}
