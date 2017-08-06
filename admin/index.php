<?php
session_start();
/**
 * @author Balaji
 * @copyright 2017
 */
 
error_reporting(1);
if(isset($_SESSION['login']))
{
    header("Location: dashboard.php");
    echo '<meta http-equiv="refresh" content="1;url=dashboard.php">';
}
else
{

}
require_once('../config.php');
$con = mysqli_connect($mysql_host,$mysql_user,$mysql_pass,$mysql_database);

  if (mysqli_connect_errno())
  {
  $sql_error = mysqli_connect_error();
    die("Unable connect to database");
  }
  
      $query =  "SELECT * FROM admin";
    $result = mysqli_query($con,$query);
        
    while($row = mysqli_fetch_array($result)) {
    $adminid =  Trim($row['user']);
    $password =   Trim($row['pass']);
    }
    
if($_SERVER['REQUEST_METHOD'] =='POST')
{
if ($adminid == htmlentities(trim($_POST['username'])))
  {
    if ($password == Md5(htmlentities(trim($_POST['password']))))
    {
        
      $msg = ' <br> <br>   <div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
                                        <b>Alert!</b> Login Successful.Redirect to admin page wait...
                                    </div>';
    $_SESSION['login'] = true;
    header("Location: dashboard.php");
    echo '<meta http-equiv="refresh" content="1;url=dashboard.php">';
    }
    else
    {
    $msg = ' <br> <br>  <div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
                                        <b>Alert!</b> Login Failed. Try Again! 
                                    </div> ';
    }
  }
  else
  {
    $msg = '   <div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
                                        <b>Alert!</b> Login Failed. Try Again! 
                                    </div> ';
  }
}

?>
<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
    <title>Login - MyPasteBox</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes"> 
    
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />

<link href="css/font-awesome.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/pages/signin.css" rel="stylesheet" type="text/css">

</head>

<body>
	
	<div class="navbar navbar-fixed-top">
	
	<div class="navbar-inner">
		
		<div class="container">
			
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			
			<a class="brand" href="index.php">
				MyPasteBox				
			</a>		
			
			<div class="nav-collapse">
				<ul class="nav pull-right">
										
					<li class="">						
						<a href="../index.php" class="">
							<i class="icon-chevron-left"></i>
							Back to Homepage
						</a>
						
					</li>
				</ul>
				
			</div><!--/.nav-collapse -->	
	
		</div> <!-- /container -->
		
	</div> <!-- /navbar-inner -->
	
</div> <!-- /navbar -->

<?php 
if (isset($msg))
{
    echo '<br /> <br /> <center> <div style="width: 60%;">'.$msg.'</div></center>';
} ?>

<div class="account-container">
	
	<div class="content clearfix">
		
		<form action="index.php" method="post">
		
			<h1>Admin Login</h1>		
			
			<div class="login-fields">
				
				<p>Please provide your details</p>
				
				<div class="field">
					<label for="username">Username</label>
					<input type="text" id="username" name="username" value="" placeholder="Username" class="login username-field" />
				</div> <!-- /field -->
				
				<div class="field">
					<label for="password">Password:</label>
					<input type="password" id="password" name="password" value="" placeholder="Password" class="login password-field"/>
				</div> <!-- /password -->
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
				
				<span class="login-checkbox">
					<input id="Field" name="Field" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" />
					<label class="choice" for="Field">Keep me signed in</label>
				</span>
									
				<button class="button btn btn-success btn-large">Sign In</button>
				
			</div> <!-- .actions -->
			
			
			
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->



<div class="login-extra">

<center>Copyright &copy; 2017 <a href="http://prothemes.biz/">ProThemes.Biz.</a> </center>
</div> <!-- /login-extra -->


<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/bootstrap.js"></script>

<script src="js/signin.js"></script>

</body>

</html>
