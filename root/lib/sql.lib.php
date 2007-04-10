<?php

define('DB_J_ADD', "INSERT INTO jobs (juser, jname, jfile, jsize, jtype) VALUES (?, ?, ?, ?, ?)");
define('DB_J_MV', "UPDATE jobs SET jfile=?, dupdated=NOW() WHERE jid=?");

define('DB_J_USER', "SELECT jid, jname, jsize, jtype, jstate, jstatus, NOW() - dupdated as jage FROM jobs WHERE juser='%s' ORDER BY jage ASC");
