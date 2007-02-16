<?php

require_once('../system.php');
require_once('cview.lib.php');

$cv = new cview();
$jobs = $cv->clusters_jobs();
$jobst = array_map('array_sum', $jobs);
print_r($jobs);
