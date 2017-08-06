<?php
session_start();
/**
 * @author Balaji
 * @copyright 2017
 */
error_reporting(1);

if(isset($_SESSION['login']))
{

}
else
{
    header("Location: index.php");
    echo '<meta http-equiv="refresh" content="1;url=index.php">';
    exit();
}
if(isset($_GET['logout']))
{
if(isset($_SESSION['login']))
unset($_SESSION['login']);

session_destroy();

echo "<br> <b> Logout Successfull.</b> <br>";
echo '<meta http-equiv="refresh" content="1;url=index.php">';
exit();
}

$date = date('jS F Y');
$ip = $_SERVER['REMOTE_ADDR'];
require_once('../config.php');
$con = mysqli_connect($mysql_host,$mysql_user,$mysql_pass,$mysql_database);

  if (mysqli_connect_errno())
  {
  $sql_error = mysqli_connect_error();
  die("Unable connect to database");
  }
  
    $query =  "SELECT @last_id := MAX(id) FROM admin_history";
    
    $result = mysqli_query($con,$query);
    
    while($row = mysqli_fetch_array($result)) {
    $last_id =  $row['@last_id := MAX(id)'];
    }
    
    $query =  "SELECT * FROM admin_history WHERE id=".Trim($last_id);
    $result = mysqli_query($con,$query);
        
    while($row = mysqli_fetch_array($result)) {
    $last_date =  $row['last_date'];
    $last_ip =  $row['ip'];
    }

    if($last_ip == $ip )
    {
    if($last_date == $date)
    {
        
    }
    else
    {
    $query = "INSERT INTO admin_history (last_date,ip) VALUES ('$date','$ip')"; 
    mysqli_query($con,$query);
    }  
    }
    else
    {
    $query = "INSERT INTO admin_history (last_date,ip) VALUES ('$date','$ip')"; 
    mysqli_query($con,$query);
    }
    
    
    $query =  "SELECT * FROM site_info";
    $result = mysqli_query($con,$query);
        
    while($row = mysqli_fetch_array($result)) {
    $title =  Trim($row['title']);
    $des =   Trim($row['des']);
    $keyword =  Trim($row['keyword']);
    $site_name =   Trim($row['site_name']);
    $email =   Trim($row['email']);
    $twit =   Trim($row['twit']);
    $face =   Trim($row['face']);
    $gplus =   Trim($row['gplus']);
    $ga =   Trim($row['ga']);
    }
        $query =  "SELECT * FROM capthca WHERE id='1'";
        $result = mysqli_query($con,$query);
        
        while($row = mysqli_fetch_array($result)) {
        $cap_e =   Trim($row['cap_e']);
        $mode =  Trim($row['mode']);
        $mul =  Trim($row['mul']);
        $allowed =  Trim($row['allowed']);
        $color =  Trim($row['color']);
        }
        
        $query =  "SELECT * FROM mail WHERE id='1'";
        $result = mysqli_query($con,$query);
        
        while($row = mysqli_fetch_array($result)) {
        $smtp_host =   Trim($row['smtp_host']);
        $smtp_username =  Trim($row['smtp_username']);
        $smtp_password =  Trim($row['smtp_password	']);
        $smtp_port =  Trim($row['smtp_port']);
        $protocol =  Trim($row['protocol']);
        $auth =  Trim($row['auth']);
        $socket =  Trim($row['socket']);
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Dashboard - MyPasteBox</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
<link href="css/font-awesome.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<link href="css/pages/dashboard.css" rel="stylesheet">
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="index.php">MyPasteBox </a>
      <div class="nav-collapse">
        <ul class="nav pull-right">
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                            class="icon-user"></i> Admin Account <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="../index.php">Visit Site</a></li>
              <li><a href="admin.php">Profile</a></li>
              <li><a href="?logout">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
      <!--/.nav-collapse --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /navbar-inner --> 
</div>
<!-- /navbar -->
<div class="subnavbar">
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="mainnav">
        <li><a href="dashboard.php"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>
        <li><a href="reports.php"><i class="icon-list-alt"></i><span>Reports</span> </a> </li>
        <li class="active"><a href="manage.php"><i class="icon-bar-chart"></i><span>Manage Site</span> </a> </li>
        <li><a href="pastes.php"><i class="icon-file"></i><span>Pastes</span> </a> </li>
        <li><a href="user.php"><i class="icon-user"></i><span>User</span> </a> </li>
        <li><a href="admin.php"><i class="icon-cogs"></i><span>Admin</span> </a> </li>
        <li><a href="pages.php"><i class="icon-book"></i><span>Pages</span> </a> </li>
        <li><a href="interface.php"><i class=" icon-eye-open"></i><span>Interface</span> </a> </li>
        <li><a href="ads.php"><i class="icon-money"></i><span>Site Ads</span> </a> </li>
        <li><a href="sitemap.php"><i class="icon-sitemap"></i><span>Sitemap</span> </a> </li>
        <li><a href="miscellaneous.php"><i class="icon-bolt"></i><span>Miscellaneous</span> </a> </li> 
      </ul>
    </div>
    <!-- /container --> 
  </div>
  <!-- /subnavbar-inner --> 
</div>
<!-- /subnavbar -->
    
                                 
<?php
if ($_SERVER['REQUEST_METHOD'] == POST)
{
    if (isset($_POST['manage']))
    {
    $title =  htmlentities(Trim($_POST['title']));
    $des =   htmlentities(Trim($_POST['des']));
    $keyword =  htmlentities(Trim($_POST['keyword']));
    $site_name =   htmlentities(Trim($_POST['site_name']));
    $email =   htmlentities(Trim($_POST['email']));
    $twit =   htmlentities(Trim($_POST['twit']));
    $face =   htmlentities(Trim($_POST['face']));
    $gplus =   htmlentities(Trim($_POST['gplus'])); 
    $ga =   htmlentities(Trim($_POST['ga'])); 
    
    $query = "UPDATE site_info SET title='$title', des='$des', keyword='$keyword', site_name='$site_name', email='$email', twit='$twit', face='$face', gplus='$gplus', ga='$ga' WHERE id='1'"; 
    mysqli_query($con,$query); 
      
    if (mysqli_errno($con)) {   
    $msg =  '<div class="alert alert-danger">
     <button data-dismiss="alert" class="close" type="button">&times;</button>
     <strong>Alert!</strong> '.mysqli_error($con).'
     </div>';
     
    }
    else
    {
         $msg = '<div class="alert alert-success">
         <button data-dismiss="alert" class="close" type="button">&times;</button>
         <strong>Alert!</strong> Site information saved successfully
         </div>';
    }
    }
if (isset($_POST['cap']))
{
    $cap_e =   Trim($_POST['cap_e']);
    $mode =  Trim($_POST['mode']);
    $mul =  Trim($_POST['mul']);
    $allowed =  Trim($_POST['allowed']);
    $color =  Trim($_POST['color']);
    
    $query = "UPDATE capthca SET cap_e='$cap_e', mode='$mode', mul='$mul', allowed='$allowed', color='$color' WHERE id='1'"; 
    mysqli_query($con,$query); 
      
    if (mysqli_errno($con)) {   
    $msg =  '<div class="alert alert-danger">
     <button data-dismiss="alert" class="close" type="button">&times;</button>
     <strong>Alert!</strong> '.mysqli_error($con).'
     </div>';
     
    }
    else
    {
         $msg = '<div class="alert alert-success">
         <button data-dismiss="alert" class="close" type="button">&times;</button>
         <strong>Alert!</strong> Captcha information saved successfully
         </div>';
    }
}

if (isset($_POST['banip']))
{
    $ban_ip = htmlentities(Trim($_POST['ban_ip']));
    $query = "INSERT INTO ban_user (last_date,ip) VALUES ('$date','$ban_ip')"; 
    mysqli_query($con,$query);
        if (mysqli_errno($con)) {   
    $msg =  '   <div class="alert alert-error">
<strong>Alert!</strong> '.mysqli_error($con).'
</div>';
    }
    else
    {
        $msg =  '
       <div class="alert alert-success">
<strong>Alert!</strong> IP added to the database.
</div>';
    }
}
}
if (isset($_GET{'delete'})) {
$delete = htmlentities(Trim($_GET['delete']));
$query = "DELETE FROM ban_user WHERE id=$delete";
$result = mysqli_query($con,$query);

    if (mysqli_errno($con)) {   
    $msg =  '   <div class="alert alert-error">
<strong>Alert!</strong> '.mysqli_error($con).'
</div>';
    }
    else
    {
        $msg =  '
       <div class="alert alert-success">
<strong>Alert!</strong> IP deleted from the database.
</div>';
    }
}

if (isset($_POST['smtp_code']))
{
    $smtp_host =   Trim($_POST['smtp_host']);
    $smtp_port =  Trim($_POST['smtp_port']);
    $smtp_username =  Trim($_POST['smtp_user']);
    $smtp_password =  Trim($_POST['smtp_pass']);
    $socket =  Trim($_POST['socket']);
    $auth =  Trim($_POST['auth']);
    $protocol =  Trim($_POST['protocol']);
    
    $query = "UPDATE mail SET smtp_host='$smtp_host', smtp_port='$smtp_port', smtp_username='$smtp_username', smtp_password='$smtp_password', socket='$socket', protocol='$protocol', auth='$auth' WHERE id='1'"; 
    mysqli_query($con,$query); 
      
    if (mysqli_errno($con)) {   
    $msg =  '<div class="alert alert-danger">
     <button data-dismiss="alert" class="close" type="button">&times;</button>
     <strong>Alert!</strong> '.mysqli_error($con).'
     </div>';
     
    }
    else
    {
         $msg = '<div class="alert alert-success">
         <button data-dismiss="alert" class="close" type="button">&times;</button>
         <strong>Alert!</strong> Mail information saved successfully
         </div>';
    }
}
?>    

<div class="main">
	
	<div class="main-inner">

	    <div class="container">
	
	      <div class="row">
	      	
	      	<div class="span12">      		
	      		
	      		<div class="widget ">
	      			
	      			<div class="widget-header">
	      				<i class="icon-bar-chart"></i>
	      				<h3>Manage Site</h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						
						
						
						<div class="tabbable">
						<ul class="nav nav-tabs">
						  <li class="active">
						    <a href="#siteinfo" data-toggle="tab">Site Info</a>
						  </li>
						  <li><a href="#captcha" data-toggle="tab">Captcha Protection</a></li>
     	                  <li><a href="#banip" data-toggle="tab">Ban IP</a></li>
                          <li><a href="#mail" data-toggle="tab">Mail</a></li>
						</ul>
						
						<br />
						
							<div class="tab-content">
								<div class="tab-pane active" id="siteinfo">
								<form id="edit-profile" class="form-horizontal" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
									<fieldset>     
                                       <?php
                                       if (isset($msg))
                                       echo $msg;
                                       ?>                                  
              				           	<div class="control-group">											
											<h3>General Information <hr /></h3>
						
										</div> <!-- /control-group -->												
										<div class="control-group">											
											<label class="control-label" for="site_name">Site Name</label>
											<div class="controls">
                                <input type="text" placeholder="Enter site name" name="site_name" id="site_name" value="<?php echo $site_name; ?>" class="span6">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
										
									<div class="control-group">											
											<label class="control-label" for="des">Title Tag</label>
											<div class="controls">
									           <input type="text" placeholder="Enter title of your site" id="title" name="title" value="<?php echo $title; ?>" class="span6">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
									<div class="control-group">											
											<label class="control-label" for="des">Description</label>
											<div class="controls">
                       <input type="text" placeholder="Enter description" id="des" name="des"  value="<?php echo $des; ?>" class="span6">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
										<div class="control-group">											
											<label class="control-label" for="keyword">Keyword's</label>
											<div class="controls">
									         <input type="text" placeholder="Enter keywords (separated by comma)" value="<?php echo $keyword; ?>"  id="keyword" name="keyword" class="span6">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                        
										<div class="control-group">											
											<label class="control-label" for="email">Email ID</label>
											<div class="controls">
		              <input type="text" placeholder="Enter email id of admin" id="email" value="<?php echo $email; ?>" name="email" class="span6">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
	                                        
                                	 <br />					                               
              				           	<div class="control-group">											
											<h3>Social Media links <hr /></h3>
						
										</div> <!-- /control-group -->
                                        
									<div class="control-group">										
											<label class="control-label" for="face">Facebook URL</label>
											<div class="controls">
                                        <input type="text" placeholder="Enter facebook URL" id="face" name="face" value="<?php echo $face; ?>" class="span6">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        

									<div class="control-group">											
											<label class="control-label" for="twit">Twitter URL</label>
											<div class="controls">
		                 <input type="text" placeholder="Enter twitter URL" id="twit" name="twit" value="<?php echo $twit; ?>" class="span6">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                        
                                        
										<div class="control-group">											
											<label class="control-label" for="gplus">Gplus URL</label>
											<div class="controls">
          <input type="text" placeholder="Enter gplus URL" id="gplus" name="gplus" value="<?php echo $gplus; ?>" class="span6">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
	
    	 <br />					                               
              				           	<div class="control-group">											
											<h3>Other <hr /></h3>
						
										</div> <!-- /control-group -->
                                        
					           	<div class="control-group">											
											<label class="control-label" for="ga">Google Analytics</label>
											<div class="controls">
                                       <input type="text" placeholder="Enter google analytics code" id="ga" name="ga" value="<?php echo $ga; ?>" class="span6">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
                                                                                       	
										 <br />
										
											
										<div class="form-actions">
											<button type="submit" class="btn btn-primary">Save</button> 
										</div> <!-- /form-actions -->
									</fieldset>
                                      <input type="hidden" name="manage" value="manage" />
								</form>
								</div>
								
								<div class="tab-pane" id="captcha" >
									<form id="edit-profile2" class="form-vertical" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
										<fieldset>
                                
                                    <div class="box-body">
                                            <div class="form-group"> 
                                            <div class="checkbox">
                                                <label class="checkbox inline" style="padding-left: 2px; ">
                                                  <input 
                                                    <?php if ($cap_e == "on")
                                                        echo 'checked="true"';
                                                    ?>
                                                    type="checkbox" name="cap_e" />
                                                    Enable captcha mode, to protect from spam and unwanted behaviour.
                                                </label>                                                
                                            </div>
                                        </div> <br />
                                        
                                   <div class="form-group">
                                            <label>Select Capthca Type</label>
                                            <select class="span6" name="mode" id="mode">
                                            <?php 
                                            if($mode == "Easy")
                                            {
                                            echo '<option selected="">Easy</option>';
                                            }
                                            else
                                            {
                                            echo '<option>Easy</option>';    
                                            }
                                            if($mode == "Normal")
                                            {
                                            echo '<option selected="">Normal</option>';
                                            }
                                            else
                                            {
                                            echo '<option>Normal</option>';    
                                            }
                                           if($mode == "Tough")
                                            {
                                            echo '<option selected="">Tough</option>';
                                            }
                                            else
                                            {
                                            echo '<option>Tough</option>';    
                                            }
                                            ?>
                                            </select>
                                        </div> <br />
                                      <div class="form-group"> 
                                            <div class="checkbox">
                                            <label class="checkbox inline" style="padding-left: 2px; ">
                                                    <input
                                                        <?php if ($mul == "on")
                                                        echo 'checked="true"';
                                                    ?> type="checkbox" name="mul" />
                                                     Enable multiple background images for captcha [More Secure] 
                                                </label>                                                
                                            </div>
                                        </div> <br />
                                         
                                        <div class="form-group">
                                            <label>Allowed characters</label>
                                            <input type="text" name="allowed"  placeholder="Enter allowed characters list..." value="<?php echo $allowed; ?>" class="span6" />
                                        </div>
                                        <div class="form-group">
                                            <label>Captcha text color</label>
                                            <input type="text" name="color"  placeholder="Enter captcha text color..." value="<?php echo $color; ?>" class="span6" />
                                        </div>
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                    </div>
										</fieldset>
                                        <input type="hidden" name="cap" value="cap" />
									</form>
								</div>
								
                                	<div class="tab-pane" id="banip">
                                    
                                    <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Add User Ban </h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
 
                                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="ban_ip">User IP:</label>
                                            <input type="text" class="form-control" id="ban_ip" name="ban_ip" placeholder="Enter user ip to ban">
                                         <input type="hidden" name="banip" value="banip" />
                                        </div><button type="submit" class="btn btn-primary">Add</button>
                                     </div><!-- /.box-body -->
                                </form>
                            </div>

         <div class="box box-info">
                                <div class="box-header">
                                    <!-- tools box -->

                                    <h3 class="box-title">
                                        Recently banned IP's
                                    </h3>
                                </div>

                                <div class="box-body">
                                    <table class="table table-striped">
                                                 <tbody><tr>
                                           <th>Added Date</th>
                                            <th>IP</th>
                                            <th>Delete</th>
                                        </tr>
                                    
<?php         
$rec_limit = 20;   
$query = "SELECT count(id) FROM ban_user";
$retval = mysqli_query($con,$query);
 
$row = mysqli_fetch_array($retval);
$rec_count = Trim($row[0]);



if (isset($_GET{'page'})) { //get the current page
$page = $_GET{'page'} + 1;
$offset = $rec_limit * $page;
} else {
// show first set of results
$page = 0;
$offset = 0;
}
$left_rec = $rec_count - ($page * $rec_limit);
//we set the specific query to display in the table
$sql = "SELECT * FROM ban_user ORDER BY `id` DESC LIMIT $offset, $rec_limit";
$result = mysqli_query($con, $sql);
$no =1;
//we loop through each records
while($row = mysqli_fetch_array($result)) {
//populate and display results data in each row
echo '<tr>';
echo '<td>' . $row['last_date'] . '</td>';
echo '<td>' . $row['ip'] . '</td>';
$myid = $row['id'];
echo '<td>' . "<a class='btn btn-danger btn-sm' href=".$_PHP_SELF."?delete=".$myid."> Delete </a>" . '</td>';
$no++;
}
echo '</tr>';
echo '</tbody>';
echo '</table>';
//we display here the pagination
echo '<ul class="pager">';
if ($left_rec < $rec_limit) {
$last = $page - 2;
if ($last < 0)
{

}
else
{
    echo @"<li><a href=\"$_PHP_SELF?page=$last\">Previous</a></li>";
}
} else if ($page == 0) {
echo @"<li><a href=\"$_PHP_SELF?page=$page\">Next</a></li>";
} else if ($page > 0) {
$last = $page - 2;
echo @"<li><a href=\"$_PHP_SELF?page=$last\">Previous</a></li> ";
echo @"<li><a href=\"$_PHP_SELF?page=$page\">Next</a></li>";
}
echo '</ul>';
?>
    
                                </div><!-- /.box-body -->

                                <div class="box-footer">

                                </div>
                            </div>
                            
									<form id="edit-profile2" class="form-vertical" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
										<fieldset>
                                        
                                        
                                        
                                        </fieldset>
                                        </form>
                                </div>
                                
                                       	<div class="tab-pane" id="mail">
                                            <br />
         	  <form id="smtp_mail" class="form-vertical" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                             <label>Select your Mail Protocol: </label>
                                           <select name="protocol"> 
                                           <?php if ($protocol == '1')
                                           {
                                            echo '<option selected value="1">PHP Mail</option>';
                                            echo '<option value="2">SMTP</option>';
                                           }
                                           else
                                           {
                                           echo '<option value="1">PHP Mail</option>';
                                            echo '<option selected value="2">SMTP</option>';
                                           } ?>

                                           </select><br /><br />
                                           
                                            <br />
                                           
                              	           	<div class="control-group">											
											<h3>SMTP Information <hr /></h3>
						
										</div> <!-- /control-group -->												
										<div class="control-group">											
											<label class="control-label" for="smtp_host">SMTP Host</label>
											<div class="controls">
                                <input type="text" placeholder="Enter smtp host" name="smtp_host" id="smtp_host" value="<?php echo $smtp_host; ?>" class="span6">
											</div> <!-- /controls -->	
										</div> <!-- /control-group -->
      				                  <div class="control-group">											
											<label class="control-label" for="smtp_auth">SMTP Auth</label>
								    <select name="auth"> 
                                    
                                            <?php if ($auth == 'true')
                                           {
                                            echo '<option selected value="true">True</option>
                                           <option value="false">False</option>';
                                           }
                                           else
                                           {
                                            echo '<option value="true">True</option>
                                           <option selected value="false">False</option>';
                                           } ?>
                                           
                                           </select>				
										</div> <!-- /control-group -->
                                <div class="control-group">											
											<label class="control-label" for="smtp_port">SMTP Port</label>
												<div class="controls">
                                <input type="text" placeholder="Enter smtp port" name="smtp_port" id="smtp_port" value="<?php echo $smtp_port; ?>" class="span6">
											</div> <!-- /controls -->				
										</div> <!-- /control-group -->
       			              <div class="control-group">											
											<label class="control-label" for="smtp_user">SMTP Username</label>
											<div class="controls">
                                <input type="text" placeholder="Enter smtp username" name="smtp_user" id="smtp_user" value="<?php echo $smtp_username; ?>" class="span6">
											</div> <!-- /controls -->	
										</div> <!-- /control-group -->
                                        
                                               <div class="control-group">											
											<label class="control-label" for="smtp_pass">SMTP Password</label>
											<div class="controls">
                                <input type="password" placeholder="Enter smtp password" name="smtp_pass" id="smtp_pass" value="<?php echo $smtp_password; ?>" class="span6">
											</div> <!-- /controls -->	
										</div> <!-- /control-group -->
                                                    
                                    <div class="control-group">											
											<label class="control-label" for="smtp_socket">SMTP Secure Socket</label>
								    <select name="socket"> 
                                         <?php if ($socket == 'tls')
                                           {
                                          echo '   
                                           <option selected value="tls">TLS</option>
                                           <option value="ssl">SSL</option>';
                                           }
                                           else
                                           {
                                            echo '   
                                           <option value="tls">TLS</option>
                                           <option selected value="ssl">SSL</option>';
                                           }
                                           ?>
                                           </select>				
										</div> <!-- /control-group -->
                                        
                                        			<div class="form-actions">
											<button type="submit" class="btn btn-primary">Save</button> 
										</div> <!-- /form-actions -->
									</fieldset>
                                      <input type="hidden" name="smtp_code" value="smtp" />
								</form>
                                           </div>
                                        
							</div>			  
						  
						</div>
							
						
					</div> <!-- /widget-content -->
						
				</div> <!-- /widget -->
	      		
		    </div> <!-- /span8 -->
	      	
	      		      	
	      	
	      </div> <!-- /row -->
	
	    </div> <!-- /container -->
	    
	</div> <!-- /main-inner -->
    
</div> <!-- /main -->
    
    
    
 
<div class="extra">
  <div class="extra-inner">
    <div class="container">
      <div class="row">
                    <div class="span3">
                        <h4>
                            Our Products</h4>
                        <ul>
                            <li><a href="https://codecanyon.net/item/atoz-seo-tools-search-engine-optimization-tools/12170678">A to Z SEO Tools</a></li>
                            <li><a href="http://codecanyon.net/item/turbo-spinner-article-rewriter/8467415">Turbo Spinner: Article Rewriter</a></li>
                            <li><a href="http://prothemes.biz/index.php?route=product/product&path=65&product_id=59">Pro IP locator Script</a></li>
                            <li><a href="https://codecanyon.net/item/custom-openvpn-gui-pro-edition/9904287">Custom OpenVPN GUI</a></li>
                            <li><a href="http://codecanyon.net/item/pptp-l2tp-vpn-client/8167857">PPTP &amp; L2TP VPN Client</a></li>
                            <li><a href="http://codecanyon.net/item/isdownornot-website-down-or-not/7472143">IsDownOrNot? Website Down or Not?</a></li>
                        </ul>
                    </div>
                    <!-- /span3 -->
                    <div class="span3">
                        <h4>
                            Support</h4>
                        <ul>
                            <li><a href="http://forum.prothemes.biz">Frequently Asked Questions</a></li>
                            <li><a href="http://prothemes.biz/index.php?route=information/contact">Ask a Question</a></li>
                            <li><a href="http://prothemes.biz/index.php?route=information/contact">Contact US</a></li>
                            <li><a href="http://prothemes.biz/index.php?route=information/contact">Feedback</a></li>
                        </ul>
                    </div>
                    <!-- /span3 -->
                    <div class="span3">
                        <h4>
                            Something Legal</h4>
                        <ul>
                            <li><a href="http://codecanyon.net/licenses">Read License</a></li>
                            <li><a href="http://prothemes.biz/index.php?route=information/information&information_id=5">Terms of Use</a></li>
                            <li><a href="http://prothemes.biz/index.php?route=information/information&information_id=3">Privacy Policy</a></li>
                        </ul>
                    </div>
                    <!-- /span3 -->
                    <div class="span3">
                        <h4>
                             Open Source Release's</h4>
                        <ul>
                            <li><a href="#">Domain Checker</a></li>
                            <li><a href="#">SSTP VPN Client</a></li>
                            <li><a href="#">HTTP Proxy Tunnel</a></li>
                        </ul>
                    </div>
                    <!-- /span3 -->
                </div>
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /extra-inner --> 
</div>
<!-- /extra -->


    
    
<div class="footer">
  <div class="footer-inner">
    <div class="container">
      <div class="row">
        <div class="span12"> &copy; 2017 MyPasteBox - <a href="http://prothemes.biz/">ProThemes.Biz</a>. </div>
        <!-- /span12 --> 
      </div>
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /footer-inner --> 
</div>
    


<script src="js/jquery-1.7.2.min.js"></script>
	
<script src="js/bootstrap.js"></script>
<script src="js/base.js"></script>


  </body>

</html>
