<?php
/*
 * @author Balaji
 */
error_reporting(1);
?>

<div id="main" class="container" role="main">
<div class="content">               
<div class="content_1"><br /><br />
<?php 

if (isset($success))
{
echo '<div class="alert alert-success">
<strong>Alert!</strong> '.$success.' <br /> '.$lang['49'].'
</div>'; 
header("Location: index.php");
echo '<meta http-equiv="refresh" content="1;url=index.php">'; 
}
elseif (isset($error))
{
    echo '<div class="alert alert-error">
<strong>Alert!</strong> '.$error.'
</div>'; 
}
if (isset($old_user))
{
echo '<br/> <div class="alert alert-info">
<strong>Alert!</strong> '.$lang['50'].'
</div>'; 
header("Location: index.php");
echo '<meta http-equiv="refresh" content="1;url=index.php">'; 
}
else
{
?>
<div class="alert alert-success">
<strong>Alert!</strong> <?php echo $lang['51']; ?>
</div>

<br />
  <form method="POST" action="/oauth.php?newuser" class="loginme-form">
			<div class="modal-body">
				<div class="info"><?php echo $lang['52']; ?></div> <br />
				
                <div class="form-group">
					<label><?php echo $lang['53']; ?><br />
						<input readonly="" style="cursor:not-allowed;" type="text" name="autoname" class="form-input" value="<?php echo $username; ?>"/>
					</label>
				</div>	
                
				<div class="form-group">
					<label><?php echo $lang['54']; ?> <br />
						<input type="text" name="new_username" class="form-input" />
					</label>
				</div>	
			</div>
			 <input type="hidden" name="user_change" value="<?php echo md5($date.$ip); ?>" />
 			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Submit</button>	
   	            <a href="/index.php" class="btn btn-primary"><?php echo $lang['55']; ?></a>	
			</div>
<?php } ?>
<br />
</div>
<div class="content_2">
<?php require_once('theme/'.$default_theme.'/sidebar.php'); ?>
</div>
<?php echo $ads_2; ?>
</div></div>