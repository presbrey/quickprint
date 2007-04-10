<?
/* QuickPrint System Configuration
 * 2006/02/16 Joe Presbrey <presbrey@mit.edu>
 */

define('L_HOME', '/~quickprint');
define('L_HTTP', 'http://quickprint.mit.edu');
define('L_HTTPS', 'https://scripts.mit.edu' . L_HOME);
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

session_name('qpID');
session_save_path('/mit/quickprint/tmp');
ini_set('upload_tmp_dir','/mit/quickprint/tmp');
ini_set('upload_max_filesize','64M');
ini_set('post_max_size','64M');
