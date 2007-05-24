<?php
?>
<a href="<?=L_BASE?>">Back to QuickPrint</a>
<?php
switch($entry) {
	case 'ipp':
?>

<?php if (isset($this->s_uName)) {
		require_once 'site/user.php';
?>
<p><h2>QuickPrint IPP Settings</h2></p>
<table>
<tr><td>Printer URL (address):</td><td><input type="text" id="URL" name="URL" value="https://quickprint.mit.edu/printer/" size=35 class="raw" readonly="readonly" onMouseUp="this.select()" /></td></tr>
<tr><td>Printer Username:</td><td><input type="text" id="auser" name="auser" value="<?=strtolower($this->s_uName)?>" size=35 class="raw" readonly="readonly" onMouseUp="this.select()" /></td></tr>
<tr><td>Printer Password:</td><td><input type="text" id="apass" name="apass" value="<?=User::ipp_get_pass($this->s_uName)?>" size=35 class="raw" readonly="readonly" onMouseUp="this.select()" /></td></tr>
</table>
<p><img src="<?=L_IMG?>info.gif" /> Windows does not support using personal MIT certificates to authenticate to network printers.  Instead, you must use this password when installing the QuickPrint printer.  You may <a href="<?=L_BASE?>user/setup">change your printer password</a> if you prefer something else.  If you do change your printer password, Windows printers using the old password will need to be reinstalled.</p>
<?php } ?>

<p><h2>Installing QuickPrint as a Network Printer on Windows XP</h2></p>
<ol style="line-height: 2em">
<li>Start the <strong>Add Printer Wizard</strong> from <em>Printers and Faxes</em> in <em>Control Panel</em>, and click <strong>Next</strong>.
<li>At the <em>Local or Network Printer</em> prompt, select the <strong>network printer</strong> option and click <strong>Next</strong>.
<li>At the <em>Specify a Printer</em> prompt, select the <strong>Connect to a printer on the Internet...</strong> option.</li>
<li>Enter <strong>https://quickprint.mit.edu/printer/</strong> in the <strong>URL</strong> box, and click <strong>Next</strong>.
<li>A <em>Configure Internet Port</em> window appears.  Select the <strong>Use the specified user account</strong> option, enter your username and printer password (not your Athena password), and click <strong>OK</strong>.</li>
<li>A new window appears requesting <em>...the manufacturer and model of your printer</em>.  Select <strong>HP</strong> from the <em>Manufacturer</em> pane, <strong>HP Color LaserJet PS</strong> from the <em>Printers</em> pane, and click <strong>OK</strong>.</li>
<li>Select whether you want to use QuickPrint as the default printer at the next prompt, click <strong>Next</strong>, and click <strong>Finish</strong>.</li>
</ol>

<?php
		break;

	default:
?>
<p><h2>Unknown FAQ Entry</h2></p>
<p>Please contact <a href="mailto:quickprint@mit.edu">quickprint@mit.edu</a> if you believe you are receiving this message in error.</p>
<?php
		break;
}
