<?php
/*
 * @author Balaji
 */
error_reporting(1);
?>
<!DOCTYPE html>
<html>
  <head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="utf-8" />
<?php
//UTF-8
header( 'Content-Type: text/html; charset=utf-8' );
?>
    <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible" />
    <title><?php if(isset($p_title)) { echo $p_title.' | ';}echo $title; ?></title>
    <meta name="description" content="<?php echo $des; ?>" />
    <meta name="keywords" content="<?php echo $keyword; ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <link href="/theme/<?php echo $default_theme; ?>/css/site.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="/theme/<?php echo $default_theme; ?>/css/medium.css" media="screen and (max-width: 1010px)" rel="stylesheet" type="text/css">
    <link href="/theme/<?php echo $default_theme; ?>/css/small.css" media="screen and (max-width: 749px)" rel="stylesheet" type="text/css">
    <link href="/theme/<?php echo $default_theme; ?>/css/reset.css" rel="stylesheet" type="text/css" />
    <link rel="icon" href="/theme/<?php echo $default_theme; ?>/img/favicon.ico" type="image/png" />
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <link rel='stylesheet prefetch' href='http://netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css' />
   	<script src="/theme/<?php echo $default_theme; ?>/js/jquery-1.11.0.min.js"></script>
    <script src="/theme/<?php echo $default_theme; ?>/js/bootstrap.min.js"></script>

    <script type="text/javascript">
      var originalNavClasses;

      function toggleNav() {
        var elem = document.getElementById('nav'),
            classes = elem.className,
            newClasses;

        if (originalNavClasses === undefined) { originalNavClasses = classes; }

        elem.className = /expanded/.test(classes) ?
                          originalNavClasses :
                          originalNavClasses + ' expanded';
      }
    </script>
<script type="text/javascript">
function valDoc()
{
var x = document.forms["mainForm"]["title"].value;
var y = document.forms["mainForm"]["paste_data"].value;
if (x==null || x=="") {
alert("Enter paste title");
return false;
}
else
{
if (y==null || y=="") {
alert("You cannot create an empty paste.");
return false;
}  
}
}
</script>
<script type="text/javascript">
function passDoc()
{
var x = document.forms["passForm"]["old_password"].value;
var y = document.forms["passForm"]["password"].value;
var z = document.forms["passForm"]["cpassword"].value;
if (x==null || x=="") {
alert("Enter your current password");
return false;
}
else
{
    if (y==null || y=="") {
        alert("Enter your new password");
        return false;
        }
        else
        {
        if (z==null || z=="") {
        alert("Confirm your new password");
        return false;
        }
        else
        {
            if (y==z) {
                }
                else
                {
                            alert("Invalid password confirmation");
                            return false;
                    
                }
        } 
        }
}
}
</script>
<script>
function togglev() {
    if(document.getElementsByTagName("ol")[0].style.listStyle.indexOf("decimal") >= 0)
    {
        document.getElementsByTagName("ol")[0].style.listStyle="none";
        document.getElementsByTagName("ol")[0].style.paddingLeft="5px";
    } else if (document.getElementsByTagName("ol")[0].style.listStyle.substr(0,4)=="")
    {
        <?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== false){ ?>
        document.getElementsByTagName("ol")[0].style.listStyle="decimal none";
        <?php }else{ ?>
        document.getElementsByTagName("ol")[0].style.listStyle="decimal";
        <?php } ?>
        document.getElementsByTagName("ol")[0].style.paddingLeft="23px";
    }  else {
        <?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== false){ ?>
        document.getElementsByTagName("ol")[0].style.listStyle="decimal none";
        <?php }else{ ?>
        document.getElementsByTagName("ol")[0].style.listStyle="decimal";
        <?php } ?>
        document.getElementsByTagName("ol")[0].style.paddingLeft="23px";
    }
}
function selectText(e) {
	if (document.selection) {
		var t = document.body.createTextRange();
		t.moveToElementText(document.getElementById(e));
		t.select()
	} else if (window.getSelection) {
		var t = document.createRange();
		t.selectNode(document.getElementById(e));
		window.getSelection().addRange(t)
	}
}

</script>
<?php
if (isset($ges_style))
{
    echo $ges_style;
}
?>
  </head>

  <body class="index">
    <div id="nav" class="container">
      <div class="content">
        <a href="/index.php" class="logo"><img src="/theme/<?php echo $default_theme; ?>/img/logo.png" /></a>
        <a href="#" class="menu-button" onclick="toggleNav(); return false;">Menu</a>
        <ul>
          <li><a href="/index.php">Home</a></li>
          <li><a href="/">Create New Paste</a></li>
          <li><a href="/archive.php">Archive</a></li>
          <li><a href="/contact.php">Contact</a></li>
          <?php if(isset($_SESSION['token']))
          { ?>
          
          <li style="margin-top: 17px;float: right;"><a href="/index.php?logout">Logout</a></li>
          <li style="margin-top: 17px;float: right;"><a href="/profile.php">My Profile</a></li>
          
          <?php } else { ?>
  <li style="margin-top: 17px;float: right;"><a data-target="#signin" data-toggle="modal" href="#">Sign In </a></li>
          <li style="margin-top: 17px;float: right;"><a data-target="#signup" data-toggle="modal" href="#">Sign Up</a></li>
          <?php } ?>
        </ul>
      </div>
    </div>
    
<!-- Sign in -->
<div class="modal fade loginme" id="signin" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Sign in</h4>
			</div>
            <form method="POST" action="/login.php?login" class="loginme-form">
			<div class="modal-body">
				<div class="alert alert-warning">
					<button type="button" class="close dismiss">&times;</button><span></span>
				</div>
				<div class="form-group connect-with">
					<div class="info">Sign in using social network</div>
					<a href="/oauth/facebook.php?login" class="connect facebook" title="Sign in using Facebook">Facebook</a>
		        	<a href="/oauth/google.php?login" class="connect google" title="Sign in using Google">Google</a>  			        
			 </div>
				<div class="info">Sign in with your username</div>
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
		</div>
	</div>
</div>


<!-- Sign up -->
<div class="modal fade loginme" id="signup" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Sign up</h4>
			</div>
			<form action="/login.php?register" method="POST" class="loginme-form">
			<div class="modal-body">
				<div class="alert alert-warning">
					<button type="button" class="close dismiss">&times;</button><span></span>
				</div>
				<div class="form-group connect-with">
					<div class="info">Sign up using social network</div>
					<a href="/oauth/facebook.php?login" class="connect facebook" title="Sign up using Facebook">Facebook</a>
		        	<a href="/oauth/google.php?login" class="connect google" title="Sign up using Google">Google</a>  			        
			 </div>
				<div class="info">Sign up with your email address</div>
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
		</div>
	</div>
</div>
