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
<tr><td>Printer URL (address):</td><td><input type="text" id="URL" name="URL" value="http://quickprint.mit.edu/printer/" size=35 class="raw" readonly="readonly" onMouseUp="this.select()" /></td></tr>
<tr><td>Printer Username:</td><td><input type="text" id="auser" name="auser" value="<?=strtolower($this->s_uName)?>" size=35 class="raw" readonly="readonly" onMouseUp="this.select()" /></td></tr>
<tr><td>Printer Password:</td><td><input type="text" id="apass" name="apass" value="<?=User::ipp_get_pass($this->s_uName)?>" size=35 class="raw" readonly="readonly" onMouseUp="this.select()" /></td></tr>
</table>
<p><img src="<?=L_IMG?>info.gif" /> Windows and Mac do not support using personal MIT certificates to authenticate to network printers.  Instead, use this password when installing the QuickPrint printer.  You may <a href="<?=L_BASE?>user/setup">change your printer password</a> if you prefer something else.</p>
<?php } ?>

<p><h2>Installing QuickPrint as a Network Printer on Windows XP</h2></p>
<ol style="line-height: 2em">
<li>Start the <strong>Add Printer Wizard</strong> from <em>Printers and Faxes</em> in <em>Control Panel</em>, and click <strong>Next</strong>.
<li>At the <em>Local or Network Printer</em> prompt, select the <strong>network printer</strong> option and click <strong>Next</strong>.
<li>At the <em>Specify a Printer</em> prompt, select the <strong>Connect to a printer on the Internet...</strong> option.</li>
<li>Enter <strong>http://quickprint.mit.edu/printer/</strong> in the <strong>URL</strong> box, and click <strong>Next</strong>.
<li>A <em>Configure Internet Port</em> window appears.  Select the <strong>Use the specified user account</strong> option, enter your username and printer password (not your Athena password), and click <strong>OK</strong>.</li>
<li>A new window appears requesting <em>...the manufacturer and model of your printer</em>.  Select <strong>HP</strong> from the <em>Manufacturer</em> pane, <strong>HP Color LaserJet PS</strong> from the <em>Printers</em> pane, and click <strong>OK</strong>.</li>
<li>Select whether you want to use QuickPrint as the default printer at the next prompt, click <strong>Next</strong>, and click <strong>Finish</strong>.</li>
</ol>

<p><a name="osx"></a><h2>Installing QuickPrint as a Network Printer on Mac OS X</h2></p>
<ol style="line-height: 2em">
<li>Start the <strong>Printer Setup Utility</strong> and select <strong>Add</strong> from toolbar or the <strong>Printers->Add Printer...</strong> menu.
<li>A <em>Printer Browser</em> window appears.  Hold <strong>Option</strong> on the keyboard and click <strong>More Printers...</strong>.
<li>A modal dialog window is superimposed.  Select <strong>Advanced</strong> from the first dropdown.</li>
<li>Select the <strong>Internet Printing Protocol using HTTP</strong> option at the <em>Device</em> prompt.</li>
<li>Enter <strong>quickprint</strong> at the <em>Device Name</em> prompt.</li>
<li>Enter the URI listed below these instructions at the <strong>Device URI</strong> prompt.</li>
<li>Select <strong>HP</strong> at the <em>Printer Model</em> prompt, <strong>HP Color LaserJet 9500</strong> from the selection pane that follows, and click <strong>Add</strong>.</li>
</ol>
<table>
<tr><td>Device URI (replace below):</td><td><input type="text" id="URL" name="URL" value="http://<?=strtolower($this->s_uName)?>:<?=User::ipp_get_pass($this->s_uName)?>@quickprint.mit.edu/printer/" size=60 class="raw" readonly="readonly" onMouseUp="this.select()" style="text-align: center" /></td></tr>
<tr><td colspan=2><img src="<?=L_IMG?>osx-10.4.png" style="border: 2px dashed #647d40; padding: 5px;" /></td></tr>
</table>
<?php
		break;

	default:
?>
<p><h2>Unknown FAQ Entry</h2></p>
<p>Please contact <a href="mailto:quickprint@mit.edu">quickprint@mit.edu</a> if you believe you are receiving this message in error.</p>
<?php
		break;
}
