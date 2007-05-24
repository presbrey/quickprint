<?php
define('DB_A_SET', 'INSERT INTO auth (auser, apass) VALUES (?,?) ON DUPLICATE KEY UPDATE apass=?');
define('DB_A_GET', "SELECT apass FROM auth WHERE auser='%s'");

define('DB_J_GET', "SELECT * FROM job WHERE jid='%d' AND juser='%s' AND jstate!='DEL' LIMIT 1");
define('DB_J_USER', "SELECT jid, jname, jtype, jqueue, jstate, jstatus, dadded, NOW() - dupdated as jage FROM job WHERE job.juser='%s' AND job.jstate!='DEL' ORDER BY jstate,jage ASC");

define('DB_J_ADD', 'INSERT INTO job (juser, jname, jfile, jsize, jtype) VALUES (?, ?, ?, ?, ?)');
define('DB_J_MV', 'UPDATE job SET jfile=?, dupdated=NOW() WHERE jid=?');
define('DB_J_RM', 'UPDATE job SET jstate=\'DEL\' WHERE jid=? and juser=?');
define('DB_J_SETQ', 'UPDATE job SET jqueue=? WHERE jid=? and juser=?');
define('DB_J_STATE', 'UPDATE job SET jstate=? WHERE jid=? and juser=?');
define('DB_J_STATUS', 'UPDATE job SET jstatus=? WHERE jid=? and juser=?');


define('DB_JO_GET', "SELECT job.*,jobopt.* FROM job LEFT JOIN jobopt ON job.jid=jobopt.jid WHERE job.jid='%d' AND job.juser='%s' AND job.jstate!='DEL' LIMIT 1");

define('DB_JO_ADD', 'INSERT INTO jobopt (jid, juser) VALUES (?,?)');
define('DB_JO_SET', 'UPDATE jobopt SET jnup=?, jbanner=?, jcopies=?, jduplex=? WHERE jid=? AND juser=?');

define('DB_JT_SET', 'UPDATE jobopt SET textnup=?,textln=?,texthon=?,textbon=?,texth=?,textlt=?,textct=?,textrt=?,textlf=?,textcf=?,textrf=? WHERE jid=? AND juser=?');
