<?php
session_start();
/**
 * @author Balaji
 * @copyright 2014
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
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Manage Pastes - MyPasteBox</title>
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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css" />
	<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
    
                	<script type="text/javascript" language="javascript" class="init">

$(document).ready(function() {
	$('#mySitesTable').dataTable( {
		"processing": true,
		"serverSide": true,
		"ajax": "ajax_pastes.php"
	} );
} );

	</script>
  
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
        <li><a href="manage.php"><i class="icon-bar-chart"></i><span>Manage Site</span> </a> </li>
        <li class="active"><a href="pastes.php"><i class="icon-file"></i><span>Pastes</span> </a> </li>
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
if (isset($_GET['delete']))
{
$delid =  htmlentities(Trim($_GET['delete']));
$query = "DELETE FROM pastes WHERE id=$delid";
$result = mysqli_query($con,$query);    
    if (mysqli_errno($con)) {   
    $msg =  '<div class="alert alert-danger">
     <strong>Alert!</strong> '.mysqli_error($con).'
     </div>';
    }
    else
    {
        $msg = '<div class="alert alert-success">
         <strong>Alert!</strong> Paste deleted from database successfully
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

	      				<i class="icon-file"></i>
	      				<h3>Manage Pastes</h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">	
                                    <?php
                                       if (isset($msg))
                                       echo '<br />'.$msg;
                                       ?>   
								<br />
                                <?php if (isset($_GET['details']))
                                { 
                                $detail_id =  htmlentities(Trim($_GET['details']));
                                $query =  "SELECT * FROM pastes WHERE id='$detail_id'";
                                $result = mysqli_query($con,$query);
                                while($row = mysqli_fetch_array($result)) {
    $p_title = $row['title'];
    $p_content = $row['content'];
    $p_visible  = $row['visible'];
    $p_code  = $row['code'];
    $p_expiry  = Trim($row['expiry']);
    $p_password  = $row['password'];
    $p_member = $row['member'];
    $p_date = $row['date'];
    $p_encrypt = $row['encrypt'];
    $p_views = $row['views'];
    $p_ip = $row['ip'];
    }
    if ($p_encrypt=="" || $p_encrypt== null || $p_encrypt=='0')
    {
        $encrypt = "Not Encrypted";
    }
    else
    {
    $encrypt = "Encrypted";
    }
    if ($p_expiry=="NULL")
    {
        $expiry = "Never";
    }
    else
    {
    $input_time = $p_expiry;
    $current_time = mktime(date("H"),date("i"),date("s"),date("n"),date("j"),date("Y"));
    if ($input_time < $current_time)
    {
    $expiry = "Paste is expired";
    }
    else
    {
        $expiry = "Not expired but soon!";
    }
    }
    
    if ($p_password == 'NONE')
    {
        $pass =  "Not protected";
    }
    else
    {
         $pass = "Password protected paste"; 
    }
    if ($p_visible == '0')
    {
        $visible = "Public";
    }
    elseif ($p_visible == '1')
    {
        $visible = "Unlisted";
    }
    elseif ($p_visible == '2')
    {
        $visible = "Private";
    }
    else
    {
        $visible = "Something went wrong!";
    }
    
    ?>
    
    <div class="widget widget-table action-table">
            <div class="widget-header"> <i class="icon-th-list"></i>
              <h3><?php echo 'PasteID: '.$detail_id.' Details'; ?></h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <table class="table table-striped table-bordered">
                <tbody>
                  <tr>
                    <td>  Username </td>
                                <td> <?php echo $p_member; ?> </td>   
                  </tr>
                                <tr>
                    <td> Paste Title </td>
        <td> <?php echo $p_title; ?> </td>
                  </tr>
                                <tr>
                    <td> Visibility </td>
                     <td> <?php echo $visible; ?> </td>
                  </tr>
                                <tr>
                    <td> Password </td>
                     <td> <?php echo $pass; ?> </td>
                  </tr>
                                <tr>
                    <td> Views Made </td>
                     <td> <?php echo $p_views; ?> </td>
                  </tr>
                                <tr>
                    <td> IP </td>
                     <td> <?php echo $p_ip; ?> </td>
                  </tr>
                                <tr>
                    <td>  Syntax Highlighting </td>
                     <td> <?php echo $p_code; ?> </td>
                  </tr>
                                <tr>
                    <td> Expiration </td>
                     <td> <?php echo $expiry; ?> </td>
                  </tr>
                  <tr>
                    <td> Encrypted Paste </td>
                     <td> <?php echo $encrypt; ?> </td>
                  </tr>

                
                </tbody>
              </table>
            </div>
            <!-- /widget-content --> 
          </div>        
                                
                                <?php } else { ?>
						         <div class="box box-primary">
                                <div class="box-header">
                                    <!-- tools box -->
                                </div>
			<fieldset>     

                                       
                                <div class="box-body">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="mySitesTable">
	<thead>
		<tr>
              <th>PasteID</th>
              <th>Username</th>
              <th>IP</th>
              <th>Visibility</th>
              <th>More Details</th>
              <th>View Paste</th>
              <th>Delete</th>
		</tr>
	</thead>         
    <tbody>
                                    
</tbody>
</table>

    
                                </div><!-- /.box-body -->

                                <div class="box-footer">

                                </div>
                            </div>  <?php } ?>
									<br />
						
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
        <div class="span12"> &copy; 2014 MyPasteBox - <a href="http://prothemes.biz/">ProThemes.Biz</a>. </div>
        <!-- /span12 --> 
      </div>
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /footer-inner --> 
</div>
    



	
<script src="js/bootstrap.js"></script>
<script src="js/base.js"></script>


  </body>

</html>
