<?php
/*
 * @author Balaji
 */
 
// Disable errors 
error_reporting(1);
?>

<div id="main" class="container" role="main">
<div class="content">
<div class="content_1">
<br /> <br />     
<?php
if (isset($error))
{
    echo '<div class="alert alert-error">
<strong>Alert!</strong> '.$error.'
</div>'; 
}
else
{
?>
<div class="alert alert-info">
<strong>Alert!</strong> <?php echo $lang['57']; ?>
</div>  <br />
<label><?php echo $lang['58']; ?></label> <br />
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
<input type="hidden" name="id" value="<?php echo $paste_id; ?>"/>
<input type="text" name="mypass" />
<input type="submit" name="submit" value="Submit" />
</form>
<?php } ?>
</div>
<div class="content_2">
<?php require_once('theme/'.$default_theme.'/sidebar.php'); ?>
</div>
<?php echo $ads_2; ?> 
</div></div>