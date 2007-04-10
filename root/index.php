<?
/* QuickPrint Request Dispatch
 * 2007/02/16 Joe Presbrey <presbrey@mit.edu>
 */

require_once 'system.php';

$euri = explode('/', isset($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : $_SERVER['REQUEST_URI'] );
if (count($euri)<2 || empty($euri[1]))
	$euri = array('', 'index');
$page = basename($euri[1], '.php');
$argv = array_slice($euri, 2);

require_once 'quickprint.php';

$site = new QPSite();
call_user_func(array($site,'Start'));
if (0 == $site->Call(ucfirst($page), strtolower($_SERVER['REQUEST_METHOD']), $argv))
	header('Location: '.L_BASE);
call_user_func(array($site, 'Finish'));

/*
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
*/
