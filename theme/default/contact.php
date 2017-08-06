<?php
/*
 * @author Balaji
 */
error_reporting(1);
?>

<div id="main" class="container" role="main">
<div class="content">                
<div class="content_1"><br />
<h3><?php echo $lang['33']; ?></h3>
<br />
<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{	
if (isset($emailSent))
{
echo '<div class="alert alert-success">
<strong>Alert!</strong> '.$lang['34'] .'
</div>'; 

}
else
{
    echo '<div class="alert alert-error">
<strong>Alert!</strong> '.$lang['35'].'
</div>'; 
}
}
?>
<br />
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal">
<div class="form-group">
<input type="text" name="name" placeholder="Your Name*" />
</div>
<div class="form-group">
<input type="text" name="email" placeholder="Your Email*" />
</div>
<div class="form-group">
<input type="text" name="subject" placeholder="Subject" />
</div>
<div class="form-group">
<textarea rows="10" name="message" placeholder="Place your message here..."></textarea>
</div>
<div class="form-group">
<input type="submit" id="" class="buttonlink" name="Submit" value="Send Message" tabindex="3" />
</div>
</form>
</div>
<div class="content_2">
<?php require_once('theme/'.$default_theme.'/sidebar.php'); ?>
</div>
<?php echo $ads_2; ?>
</div></div>