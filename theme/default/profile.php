<?php
/*
 * @author Balaji
 */
error_reporting(1);
?>

<div id="main" class="container" role="main">
<div class="content">                
<div class="content_1"><br />
<h3 style="font-weight: bold; font-size: 18px;"><?php echo $lang['59']; ?></h3>
<br />
<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{	
if (isset($success))
{
echo '<div class="alert alert-success">
<strong>Alert!</strong> '.$success.'
</div>'; 
}
elseif (isset($error))
{
    echo '<div class="alert alert-error">
<strong>Alert!</strong> '.$error.'
</div>'; 
}
}
?>
<br />
<div class="profile_view">
<span><?php echo $lang['60']; ?> <?php echo $total_pastes; ?> </span><br /><br />
<span><?php echo $lang['61']; ?> Free </span>
<span class="pro_button"><a class="btn btn-primary"  href="/mypastes.php" target="_self" title="View all pastes">View all My Pastes!</a></span><br /><br />
 </div>

<br /><br />
<div class="form-group">
<label><?php echo $lang['62']; ?></label>
<input disabled="" type="text" class="form-input"  name="username" style="cursor:not-allowed;" placeholder="Your username" value="<?php echo $user_username; ?>" />
</div>

<div class="form-group">
<label><?php echo $lang['63']; ?></label>
<input <?php if ($user_verified == "1")
{
    echo 'disabled="" style="cursor:not-allowed;"';
} ?> type="text" name="email" placeholder="Your Email*" class="form-input"   value="<?php echo $user_email_id; ?>" />
</div>
<hr /> <br />
<form name="passForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return passDoc()" class="form-horizontal">
<div class="form-group">
<label><?php echo $lang['64']; ?></label>
<input type="text" name="full" placeholder="Your full name" class="form-input"  value="<?php echo $user_full_name; ?>" />
</div>
<label style="font-weight: bold;"><?php echo $lang['65']; ?> </label> <br /> <br />

<div class="form-group">
<label><?php echo $lang['66']; ?></label>
<input type="password" name="old_password" placeholder="Your current password" class="form-input" />
</div>

<div class="form-group">
<label><?php echo $lang['67']; ?></label>
<input type="password" name="password" placeholder="Your new password" class="form-input" />
</div>
<div class="form-group">
<label><?php echo $lang['68']; ?></label>
<input type="password" name="cpassword" placeholder="Confirm new password" class="form-input"  />
</div>
<div class="form-group">
<input type="submit" id="" class="buttonlink" name="Submit" value="Submit" tabindex="3" />
</div>
</form>
</div>
<div class="content_2">
<?php require_once('theme/'.$default_theme.'/sidebar.php'); ?>
</div>
<?php echo $ads_2; ?> 
</div></div>