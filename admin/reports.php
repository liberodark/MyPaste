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

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Reports - MyPasteBox</title>
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
        <li class="active"><a href="reports.php"><i class="icon-list-alt"></i><span>Reports</span> </a> </li>
        <li><a href="manage.php"><i class="icon-bar-chart"></i><span>Manage Site</span> </a> </li>
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
//Post Handler
}

    $query =  "SELECT * FROM page_view";
    $result = mysqli_query($con,$query);
        
    while($row = mysqli_fetch_array($result)) {
    $total_page =  $total_page + Trim($row['tpage']);
    $total_un =  $total_un + Trim($row['tvisit']);
    }
    
    
    $query =  "SELECT * FROM pastes";
    $result = mysqli_query($con,$query);
    $total_pastes = 0;
    $exp_pastes = 0;
    while($row = mysqli_fetch_array($result)) {
    $total_pastes =  $total_pastes + 1;
    $p_expiry  = Trim($row['expiry']);
        if ($p_expiry=="NULL" || $p_expiry=="SELF")
    {}
    else
    {
    $input_time = $p_expiry;
    $current_time = mktime(date("H"),date("i"),date("s"),date("n"),date("j"),date("Y"));
    if ($input_time < $current_time)
    {
    $exp_pastes =  $exp_pastes + 1;
    }
    }
    }
    
    $query =  "SELECT * FROM users";
    $result = mysqli_query($con,$query);
    $total_users = 0;
    $total_ban = 0;
    $not_ver = 0;
    while($row = mysqli_fetch_array($result)) {
    $total_users =  $total_users + 1;
    $p_v  = Trim($row['verified']);
    if ($p_v == '2')
    {
    $total_ban =  $total_ban + 1;
    }
    if ($p_v == '0')
    {
    $not_ver =  $not_ver + 1;
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
	      				<i class="icon-list-alt"></i>
	      				<h3>Reports</h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
				
	      <div class="box"><br />
                                <div class="box-header">
                                    <h3 class="box-title"> Overall status</h3>
        
                                </div><!-- /.box-header --> 
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-bordered">
                                        <tbody>
                                        
                                        <tr>
                                            <th>#</th>
                                            <th>Task</th>
                                            <th>Stats</th>
                                        </tr>
                                        
                                        <tr>
                                            <td>1</td>
                                            <td>Total Pastes</td>
                                            <td><span class="label label-success"><?php echo $total_pastes; ?></span></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Expired Pastes</td>
                                            <td><span class="label label-important"><?php echo $exp_pastes; ?></span></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Total Users</td>
                                            <td><span class="label label-info"><?php echo $total_users; ?></span></td>
                                        </tr>
                                                  <tr>
                                            <td>4</td>
                                            <td>Total Banned Users</td>
                                            <td><span class="label label-warning"><?php echo $total_ban; ?></span></td>
                                        </tr>  
                                        <tr>
                                            <td>5</td>
                                            <td>Not verified users</td>
                                            <td><span class="label label-important"><?php echo $not_ver; ?></span></td>
                                        </tr>  
                                        <tr>
                                            <td>6</td>
                                            <td>Total Page Views</td>
                                            <td><span class="label label-success"><?php echo $total_page; ?></span></td>
                                        </tr>  
                                            <tr>
                                            <td>7</td>
                                            <td>Total Unique Visitors</td>
                                            <td><span class="label label-success"><?php echo $total_un; ?></span></td>
                                        </tr>  
                                          
                                    </tbody></table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                            
                            
                            
                <div class="box box-success" id="loading-example"> <br />
                                <div class="box-header">
                                    <!-- tools box -->
                
                                   <i class="fa fa-map-marker"></i>

                                    <h3 class="box-title">PageViews Status</h3>
                                </div><!-- /.box-header -->

        <?php 
        $query =  "SELECT @last_id := MAX(id) FROM page_view";
    
    $result = mysqli_query($con,$query);
    
    while($row = mysqli_fetch_array($result)) {
    $page_last_id =  $row['@last_id := MAX(id)'];
    }
    $query =  "SELECT * FROM page_view WHERE id=".Trim($page_last_id);
    $result = mysqli_query($con,$query);
        
    while($row = mysqli_fetch_array($result)) {
    $date =  $row['date'];
    $tpage =  $row['tpage'];
    $tvisit =  $row['tvisit'];
    }
        
        ?>
                       
                                <div class="box-body">
                                    <table class="table table-bordered">
                                        <tbody><tr>
                                            <th style="width: 10px">#</th>
                                            <th>Date</th>
                                            <th>Unique Visitors</th>
                                            <th style="width: 130px">PageViews</th>
                                        </tr>
                                        <tr>
                                            <td>1.</td>
                                            <td><?php echo $date; ?></td>
                                           <td><?php echo $tvisit; ?></td>
                                           <td><?php echo $tpage; ?></td>
                                        </tr>
    <?php                                   
    $page_last_id = $page_last_id - 1;                               
    $query =  "SELECT * FROM page_view WHERE id=".Trim($page_last_id);
    $result = mysqli_query($con,$query);
        
    while($row = mysqli_fetch_array($result)) {
    $date =  $row['date'];
    $tpage =  $row['tpage'];
    $tvisit =  $row['tvisit'];
    }
    ?>
                                        <tr>
                                            <td>2.</td>
                                                  <td><?php echo $date; ?></td>
                                           <td><?php echo $tvisit; ?></td>
                                           <td><?php echo $tpage; ?></td>
                                        </tr>
                                            <?php                                   
    $page_last_id = $page_last_id - 1;                               
    $query =  "SELECT * FROM page_view WHERE id=".Trim($page_last_id);
    $result = mysqli_query($con,$query);
        
    while($row = mysqli_fetch_array($result)) {
    $date =  $row['date'];
    $tpage =  $row['tpage'];
    $tvisit =  $row['tvisit'];
    }
    ?>
                                        <tr>
                                            <td>3.</td>
                                          <td><?php echo $date; ?></td>
                                           <td><?php echo $tvisit; ?></td>
                                           <td><?php echo $tpage; ?></td>
                                        </tr>
                                            <?php                                   
    $page_last_id = $page_last_id - 1;                               
    $query =  "SELECT * FROM page_view WHERE id=".Trim($page_last_id);
    $result = mysqli_query($con,$query);
        
    while($row = mysqli_fetch_array($result)) {
    $date =  $row['date'];
    $tpage =  $row['tpage'];
    $tvisit =  $row['tvisit'];
    }
    ?>
                                        <tr>
                                            <td>4.</td>
                                            <td><?php echo $date; ?></td>
                                           <td><?php echo $tvisit; ?></td>
                                           <td><?php echo $tpage; ?></td>
                                        </tr>
                                            <?php                                   
    $page_last_id = $page_last_id - 1;                               
    $query =  "SELECT * FROM page_view WHERE id=".Trim($page_last_id);
    $result = mysqli_query($con,$query);
        
    while($row = mysqli_fetch_array($result)) {
    $date =  $row['date'];
    $tpage =  $row['tpage'];
    $tvisit =  $row['tvisit'];
    }
    ?>
                                         <tr>
                                            <td>5.</td>
                                        <td><?php echo $date; ?></td>
                                           <td><?php echo $tvisit; ?></td>
                                           <td><?php echo $tpage; ?></td>
                                        </tr>
                                    </tbody></table>
                                </div><!-- /.box-body -->
                       
                 
                                <div class="box-footer">
                         
                                </div><!-- /.box-footer -->
                            </div><!-- /.box -->      
                            
                            
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
