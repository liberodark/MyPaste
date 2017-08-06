<?php
/*
 * @author Balaji
 */
error_reporting(1);
?>
<div id="main" class="container" role="main">
<div class="content">
<div class="content_1">
<div class="row-fluid"> 
<div class="span12">
<div class="top-bar">
<style>
.copy_alert
{
    display: none;
}
</style>
<script>
$(document).ready(function () {
    $('#showmenu').click(function (e) {
        $('.copy_alert').stop(true).slideToggle();
    });
    $(document).click(function (e) {
        if (!$(e.target).closest('#showmenu, .copy_alert').length) {
            $('.copy_alert').stop(true).slideUp();
        }
    });
});
</script>
<div class="copy_alert">
<div class="alert alert-success">
<?php echo $lang['78']; ?>
</div>
</div>
<div class="paste_box_icon">
<img border="0" alt="Guest" src="/theme/<?php echo $default_theme; ?>/img/user.png" />	
</div>
<b>
<?php $p_title=truncate($p_title, 5, 40); echo ucfirst($p_title); ?></b>
<small><br />
<?php echo 'By '.$p_member.' on '.$p_date.' | Syntax: '.strtoupper($p_code).' | Views: '.$p_views; ?></small>
<br /><br /><br />
<a href="/index.php"><img src="/theme/<?php echo $default_theme; ?>/img/edit-paste.png" /> <?php echo $lang['79']; ?></a> |
<a href="<?php echo $p_download; ?>"><img src="/theme/<?php echo $default_theme; ?>/img/download.png" /> <?php echo $lang['80']; ?></a> | 
<a title="Show/Hide line numbers" href="javascript:togglev();"><img src="/theme/<?php echo $default_theme; ?>/img/toggle.png" />  <?php echo $lang['81']; ?></a> | 
<a title="Copy text to clipboard" onclick="selectText('p_data');" id="showmenu" href="#"><img src="/theme/<?php echo $default_theme; ?>/img/copy.png" />  <?php echo $lang['82']; ?></a>
</ul>
</div>
<div id="p_data">
<?php 
if (isset($error))
{
echo '<div class="alert alert-error">
<strong>Alert!</strong> '.$error.'
</div>'; 
}
else
{
echo $p_content;
?>
</div>
<script>
$(document).ready(function() {
togglev();
});
</script>
<br /> <br /> <label style="font-weight: bold;"><?php echo $lang['83']; ?></label><br />
<textarea rows="20"><?php echo $op_content; ?></textarea>
<?php
}
?>
</div></div></div>
<div class="content_2">
<?php require_once('theme/'.$default_theme.'/sidebar.php'); ?>
</div>
<?php echo $ads_2; ?> 
</div></div>