<?
/* QuickPrint System Configuration
 * 2006/02/16 Joe Presbrey <presbrey@mit.edu>
 */

file_exists('config.php') && require('config.php');

define('L_HOME', '/~quickprint');
define('L_HTTP', 'http://quickprint.mit.edu');
if (strstr($_SERVER['HTTP_USER_AGENT'], 'Safari')) {
    define('L_HTTPS', 'https://scripts.mit.edu:444' . L_HOME);
} else {
    define('L_HTTPS', 'https://scripts.mit.edu' . L_HOME);
}
define('L_BASE', L_HTTP.'/');
define('L_IMG', L_HTTP.'/img/');

define('P_TOP', dirname(__FILE__));
define('P_BASE', realpath(P_TOP.'/'));
define('P_ROOT', realpath(P_TOP.'/../'));
define('P_LIB', P_TOP.'/lib/');
define('P_INC', P_TOP.'/inc/');
define('P_BIN', '/mit/quickprint/bin/');
define('P_FILTERS', '/mit/quickprint/libexec/filters/');

set_include_path(get_include_path()
				. PATH_SEPARATOR . P_LIB
				. PATH_SEPARATOR . P_INC);

session_name('qpID');
session_save_path('/mit/quickprint/tmp');
