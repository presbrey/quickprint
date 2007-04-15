<?
/* QuickPrint Request Dispatch
 * 2007/02/16 Joe Presbrey <presbrey@mit.edu>
 */
require_once 'system.php';

$euri = explode('/', isset($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : $_SERVER['REQUEST_URI'] );
if (count($euri)<2 || empty($euri[1]))
	$euri = array('', 'index');
$euri[0] = $_SERVER['SERVER_NAME'];

require_once 'quickprint.php';

$site = new QPSite($euri);
$site->Start();
if (0 == $site->Run(ucfirst($euri[1]), strtolower($_SERVER['REQUEST_METHOD']))) {
	header('Location: '.L_BASE);
}
$site->Finish();
