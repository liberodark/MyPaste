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
<strong>Alert!</strong> '.$success.'
</div>'; 

if (isset($_GET['login']))
{
echo '<br/> <div class="alert alert-info">
<strong>Alert!</strong> '.$lang['36'].'
</div>'; 
header("Location: /index.php");
echo '<meta http-equiv="refresh" content="1;url=/index.php">';
}
if (isset($_GET['register']))
{
echo '<br/> <div class="alert alert-info">
<strong>Alert!</strong> '.$lang['37'].'
</div>'; 
}
}
elseif (isset($error))
{
    echo '<div class="alert alert-error">
<strong>Alert!</strong> '.$error.'
</div>'; 
}
if (isset($_GET['login']))
{
?>
  <form method="POST" action="/login.php?login" class="loginme-form">
			<div class="modal-body">

				<div class="form-group connect-with">
					<div class="info">Sign in using social network</div> <br />
					<a href="/oauth/facebook.php?login" class="connect facebook" title="Sign in using Facebook">Facebook</a>
		        	<a href="/oauth/google.php?login" class="connect google" title="Sign in using Google">Google</a>    			        
			 </div>
				<div class="info">Sign in with your username</div> <br />
				<div class="form-group">
					<label>Username <br />
						<input type="text" name="username" class="form-input" />
					</label>
				</div>	
				<div class="form-group">
					<label>Password <br />
						<input type="password" name="password" class="form-input" />
					</label>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Sign in</button>
				<div class="pull-right align-right">
					<a href="/login.php?forget" >Forgot Password</a><br />
					<a href="/login.php?resend" >Resend activation email</a>
				</div>
			</div>
			 <input type="hidden" name="signin" value="<?php echo md5($date.$ip); ?>" />
			</form> 
<?php } elseif (isset($_GET['register']))  {?>
<form action="/login.php?register" method="POST" class="loginme-form">
			<div class="modal-body">
				<div class="form-group connect-with">
					<div class="info">Sign up using social network</div> <br />
					<a href="/oauth/facebook.php?login" class="connect facebook" title="Sign up using Facebook">Facebook</a>
		        	<a href="/oauth/google.php?login" class="connect google" title="Sign up using Google">Google</a>   			        
			 </div>
				<div class="info">Sign up with your email address</div><br />
								<div class="form-group">
					<label>Username <br />
						<input type="text" name="username" class="form-input" />
					</label>
				</div>	
								<div class="form-group">
					<label>Email <br />
						<input type="text" name="email" class="form-input" />
					</label>
				</div>
								<div class="form-group">
					<label>Full Name <br />
						<input type="text" name="full" class="form-input" />
					</label>
				</div>
								<div class="form-group">
					<label>Password <br />
						<input type="password" name="password" class="form-input" />
					</label>
				</div>
				</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Sign up</button>	
			</div>
			 <input type="hidden" name="signup" value="<?php echo md5($date.$ip); ?>" />
			</form>
            
<?php } elseif (isset($_GET['forget']))  {?>

<form action="/login.php?forget" method="POST" class="loginme-form">
		
        	<div class="modal-body">

				<div class="info">Enter your email address</div><br />
	
								<div class="form-group">
					<label>Email <br />
						<input type="text" name="email" class="form-input" />
					</label>
				</div>

				</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Forget Password</button>	
			</div>
			 <input type="hidden" name="forget" value="<?php echo md5($date.$ip); ?>" />
			</form>
            
<?php } elseif (isset($_GET['resend']))  {?>   
   <form action="/login.php?resend" method="POST" class="loginme-form">
		
        	<div class="modal-body">

				<div class="info">Enter your email address</div><br />
	
								<div class="form-group">
					<label>Email <br />
						<input type="text" name="email" class="form-input" />
					</label>
				</div>

				</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Resend Activation Code</button>	
			</div>
			 <input type="hidden" name="resend" value="<?php echo md5($date.$ip); ?>" />
			</form>   
<?php } else  {?> <br />
Options: <br /><br />
<a href="/login.php?login" >Login to your Account</a><br />
<a href="/login.php?register" >Register an account</a> <br />     
<a href="/login.php?forget" >Forgot Password</a><br />
<a href="/login.php?resend" >Resend activation email</a><br />
<?php  } ?>
<br />
</div>
<div class="content_2">
<?php require_once('theme/'.$default_theme.'/sidebar.php'); ?>
</div>
<?php echo $ads_2; ?>
</div></div>