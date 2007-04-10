<div align=right nowrap style="position: absolute; right: 4px; top: 4px;">
<font size="-1"><strong>

<? /* <a href="<?=L_BASE?>">Home</a> &nbsp;|&nbsp; */ ?>
<? if (isset($_SESSION['uUser'])) { ?>
<?=strtolower($_SESSION['uEmail'])?>
<? /* &nbsp;|&nbsp; <a href="<?=L_BASE?>logout">Sign out</a> */ ?>
<? } else { ?>
<a href="<?=L_HTTPS?>/auth<?=$_SERVER['REQUEST_URI']?>">Sign in</a>
<? } ?>
</strong></font>
</div>
