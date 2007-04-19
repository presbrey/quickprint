<?php

switch($error) {
	case 'cert':
?>
<p><h2>Invalid MIT SSL Certificate</h2></p>
<p>A valid MIT certificate is required to access QuickPrint.
 Install your <a target="_new" href="http://ca.mit.edu/">MIT certificate</a>
 and <a href="<?=L_BASE?>">try again</a>.</p>
<p>You may need to restart your browser after installing your certificate.</p>
<?php
		break;
	case 'upload_max':
?>
<p><h2>Upload Error: </h2></p>
<p>The file you chose was too large (&gt;8M).  Try again with a smaller file or visit an Athena cluster if you must print large files.</p>
<p><a href="<?=L_BASE?>">>> QuickPrint Home</a></p>
<?php
		break;
	case 'upload_part':
?>
<p><h2>Upload Error: </h2></p>
<p>The upload was interrupted.  Try again.</p>
<p><a href="<?=L_BASE?>">>> QuickPrint Home</a></p>
<?php
		break;
	case 'upload_empty':
?>
<p><h2>Upload Error: </h2></p>
<p>You must select a file to use QuickPrint.</p>
<p><a href="<?=L_BASE?>">>> QuickPrint Home</a></p>
<?php
		break;
	case 'upload_disk':
?>
<p><h2>Upload Error: </h2></p>
<p>The QuickPrint disk is full.  Please contact the administrators: <a href="mailto:quickprint@mit.edu">quickprint@mit.edu</a>.</p>
<?php
		break;
	default:
?>
<p><h2>An unknown error occurred</h2></p>
<p>Please contact <a href="mailto:quickprint@mit.edu">quickprint@mit.edu</a> for assistance.</p>
<?php
		break;
}
