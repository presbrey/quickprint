<?php
if ($this->has_errors()) {
	echo '<span class="errors">Your submission is in error.  Please correct the errors in red below.</span>';
}
?>
<form method="post" action="<?=$_SERVER['REQUEST_URI']?>">
<p><h2>IPP Printing Preferences</h2></p>
<?php
$pass = $this->ipp_get_pass($this->s_uName);
?>
<table class="box">
<!--<tr><td>URL:</td><td>https://quickprint.mit.edu/printer/</td></tr>
<tr><td>Username:</td><td><?=$this->s_uName?></td></tr>-->
<tr><td colspan=2><?=$this->error('')?></td></tr>
<tr><td>Password:</td><td><input type="text" name="apass" id="apass" value="<?=$pass?>" style="font-family: Courier" /></td></tr>
<tr><td colspan=2>
<p><img src="<?=L_IMG?>info.gif"> Windows will ask you for this password <br />when you <a href="/faq/ipp">install the printer</a>.  If you change <br />your printer password, Windows printers <br />using the old password will need to be <br />reinstalled.</p>
</td></tr>
</table>

<p><h2>Finish</h2></p>
<p>
<input type="submit" name="save" value="Save" />
<input type="button" value="Cancel" onClick="location='<?=L_BASE?>';" />
</p>
</form>
