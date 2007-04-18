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
	default:
?>
<p><h2>An unknown error occurred</h2></p>
<p>Please contact <a href="mailto:quickprint@mit.edu">quickprint@mit.edu</a> for assistance.</p>
<?php
		break;
}
