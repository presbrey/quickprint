<?php
require_once('cview.lib.php');
$cview = new cview();
$printers = 0;
$jobs = 0;
foreach ($cview->printers() as $name=>$data) {
    $printers += 1;
    $jobs += $data['jobs'];
}
echo "$jobs jobs on $printers printers";
