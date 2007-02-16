<?
/* System Configuration
 * 2006/02/16 Joe Presbrey <presbrey@mit.edu>
 */

define('L_HTTP', 'http://quickprint.mit.edu');
define('L_HTTPS', 'https://scripts-cert.mit.edu/~quickprint/root');
define('L_BASE', L_HTTP.'/');
define('L_IMG', L_HTTP.'/img/');

define('P_TOP', dirname(__FILE__));
define('P_BASE', realpath(P_TOP.'/'));
define('P_ROOT', realpath(P_TOP.'/../'));
define('P_LIB', P_TOP.'/lib/');
define('P_INC', P_TOP.'/inc/');

set_include_path(get_include_path()
				. PATH_SEPARATOR . P_LIB
				. PATH_SEPARATOR . P_INC);
