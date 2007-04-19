<?php
if ($this->has_errors()) {
	echo '<span class="errors">Your submission is in error.  Please correct the errors in red below.</span>';
}
?>
<p><h2>Document Properties</h2></p>
<form method="post" action="<?=$_SERVER['REQUEST_URI']?>">
<input type="hidden" name="setup" value="<?=$jid?>" />
<table>
<tr><td>Name:</td><td><?=$job['jname']?></td></tr>
<tr><td colspan=2><?=$this->error('jtype')?></td></tr>
<tr><td>Type:</td><td><?=$job['jtype']?></td></tr>
<tr><td>Size:</td><td><?=bytes_h($job['jsize'])?></td></tr>
<tr><td>Date:</td><td><?=$job['dadded']?></td></tr>
</table>

<?php if ($this->get_job_mode($job) == 'text') { ?>
<p><h2>Plain Text Document Settings</h2></p>
<p><img src="<?=L_IMG?>info.gif"> PDF/PostScript document not detected.  Assuming plain-text format.</p>
<p><?=$this->error('textnup')?></p>
<p><?=$this->error('textln')?></p>
<p><?=$this->error('texthon')?></p>
<p><?=$this->error('textbon')?></p>
<table>
<tr>
<td>Pages per sheet:</td><td>
<select name="textnup" class="text_nup">
<?php for ($i=1; $i<=9; $i++) { ?>
<option value="<?=$i?>"<?=$i==$job['textnup']?' selected':''?>><?=$i?></option>
<?php } ?>
</select></td>
<td>Line numbering every:</td><td><input type="text" name="textln" size="1" value="<?=$job['textln']?>" /> line</td>
<td>Sheet header:</td><td><input class="text_set" type="text" name="texth" value="<?=$job['texth']?>"<?=0==$job['texthon']?' disabled':''?>/></td>
</tr><tr>
<td>Left page title:</td><td><input class="text_set" type="text" name="textlt" value="<?=$job['textlt']?>"<?=0==$job['texthon']?' disabled':''?>/></td>
<td>Center page title:</td><td><input class="text_set" type="text" name="textct" value="<?=$job['textct']?>"<?=0==$job['texthon']?' disabled':''?>/></td>
<td>Right page title:</td><td><input class="text_set" type="text" name="textrt" value="<?=$job['textrt']?>"<?=0==$job['texthon']?' disabled':''?>/></td>
</tr><tr>
<td>Left sheet footer:</td><td><input class="text_set" type="text" name="textlf" value="<?=$job['textlf']?>"<?=0==$job['texthon']?' disabled':''?>/></td>
<td>Center sheet footer:</td><td><input class="text_set" type="text" name="textcf" value="<?=$job['textcf']?>"<?=0==$job['texthon']?' disabled':''?>/></td>
<td>Right sheet footer:</td><td><input class="text_set" type="text" name="textrf" value="<?=$job['textrf']?>"<?=0==$job['texthon']?' disabled':''?>/></td>
</tr><tr>
<td>Disable headers and footers:</td><td>
<input class="text_on" type="radio" name="texthon"<?=1==$job['texthon']?' checked':''?> value="1" onClick="var t=$A(document.getElementsByClassName('text_set')); t.each(Form.Element.enable);" />No
<input class="text_on" type="radio" name="texthon"<?=0==$job['texthon']?' checked':''?> value="0" onClick="var t=$A(document.getElementsByClassName('text_set')); t.each(Form.Element.disable);" />Yes
</td>
<td>Disable column borders:</td><td>
<input class="text_on" type="radio" name="textbon"<?=1==$job['textbon']?' checked':''?> value="1" />No
<input class="text_on" type="radio" name="textbon"<?=0==$job['textbon']?' checked':''?> value="0" />Yes
</td>
</table>

<?php } ?>

<p><h2>Printing Properties</h2></p>

<?php if (empty($job['jqueue'])) { ?>
Choose a printer for this document by clicking "select" next to "Printer" below or print the document later by clicking "Save".
<?php } ?>
<table>
<tr><td colspan=2><?=$this->error('jqueue')?></td></tr>
<tr><td>Printer:</td><td>
<?php printf('%s <input type="submit" name="queue" value="select" />', $job['jqueue'], L_BASE.'queue/?jid='.$jid); ?>
</td></tr>
<tr><td colspan=2><?=$this->error('jduplex')?></td></tr>
<tr><td>Duplex printing:</td><td>
<input type="radio" name="jduplex" value="0"<?=($job['jduplex']==0?' checked':'')?> />
<label>Off</label>
<input type="radio" name="jduplex" value="1"<?=($job['jduplex']==1?' checked':'')?> />
<label>On</label>
</td></tr>
<? /*
<tr><td colspan=2><?=$this->error('jnup')?></td></tr>
<tr><td>Multiple pages per sheet:</td><td>
<select name="jnup">
<option value="1"<?=1==$job['jnup']?' selected':''?>>1</option>
<option value="2"<?=2==$job['jnup']?' selected':''?>>2</option>
<option value="4"<?=4==$job['jnup']?' selected':''?>>4</option>
</select>
</td></tr>
*/ ?>
</table>
<p><h2>Finish</h2></p>
<table>
<tr><td colspan=2>
<?php if ($job_edit == false) { ?>
<input type="submit" name="print" value="Print" />
<?php } ?>
<input type="submit" name="save" value="Save" />
<input type="submit" name="preview" value="Preview" />
</form>
<form method="get">
<input type="hidden" name="jid" value="<?=$jid?>" />
<input type="submit" name="del" value="Delete" />
</form>
<input type="button" value="Cancel" onClick="location='<?=L_BASE?>';" />
</td></tr>
</table>
</form>
