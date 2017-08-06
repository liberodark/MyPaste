<?php session_start(); ?>
<?php
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
$today_users_count = 0;
$today_pastes_count = 0;

$date = date('jS F Y');
$ip = $_SERVER['REMOTE_ADDR'];
require_once('../config.php');
require_once('../core/functions.php');
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
    
    
    $query =  "SELECT * FROM page_view";
    $result = mysqli_query($con,$query);
        
    while($row = mysqli_fetch_array($result)) {
    $total_page =  $total_page + Trim($row['tpage']);
    $total_visit =  $total_visit + Trim($row['tvisit']);
    }
    
    $query =  "SELECT @last_id := MAX(id) FROM page_view";
    
    $result = mysqli_query($con,$query);
    
    while($row = mysqli_fetch_array($result)) {
    $page_last_id =  $row['@last_id := MAX(id)'];
    }
    
    $query =  "SELECT * FROM page_view WHERE id=".Trim($page_last_id);
    $result = mysqli_query($con,$query);
        
    while($row = mysqli_fetch_array($result)) {
    $today_page =  $row['tpage'];
    $today_visit =  $row['tvisit'];
    }
    

    $query =  "SELECT * FROM site_info";
    $result = mysqli_query($con,$query);
        
    while($row = mysqli_fetch_array($result)) {
    $admin_email =   Trim($row['email']);
    }
    
    $c_date = date('jS F Y');
    $query =  "SELECT * FROM users where date='$c_date'";
    $result = mysqli_query($con,$query);
 
    while($row = mysqli_fetch_array($result)) {
    $today_users_count = $today_users_count +1;
    }
    
    $query =  "SELECT * FROM pastes where s_date='$c_date'";
    $result = mysqli_query($con,$query);
 
    while($row = mysqli_fetch_array($result)) {
    $today_pastes_count = $today_pastes_count +1;
    }
for ($loop=0; $loop<=6; $loop++)
{   
    $myid = $page_last_id - $loop;
    $query =  "SELECT * FROM page_view WHERE id='$myid'";
    $result = mysqli_query($con,$query);

    while($row = mysqli_fetch_array($result)) {
    $sdate = $row['date'];
    $sdate= str_replace(date('Y'),'',$sdate);
    $sdate= str_replace('January','Jan',$sdate);
    $sdate= str_replace('February','Feb',$sdate);
    $sdate= str_replace('March','Mar',$sdate);
    $sdate= str_replace('April','Apr',$sdate);
    $sdate= str_replace('August','Aug',$sdate);
    $sdate= str_replace('September','Sep',$sdate);
    $sdate= str_replace('October','Oct',$sdate);
    $sdate= str_replace('November','Nov',$sdate);
    $sdate= str_replace('December','Dec',$sdate);
              
    $ldate[$loop] =  $sdate;
    $tpage[$loop] =  $row['tpage'];
    $tvisit[$loop] =  $row['tvisit'];
    }   
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
<style> 
.badge {
    background-color: #999999;
    border-radius: 10px;
    color: #FFFFFF;
    display: inline-block;
    font-size: 12px;
    font-weight: bold;
    line-height: 1;
    min-width: 10px;
    padding: 3px 7px;
    text-align: center;
    vertical-align: baseline;
    white-space: nowrap;
}
.bg-purple {
    background-color: #932AB6 !important;
}
.bg-light-blue {
    background-color: #3C8DBC !important;
}
.bg-black {
    color: #F9F9F9 !important;
}
</style>
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
        <li class="active"><a href="dashboard.php"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>
        <li><a href="reports.php"><i class="icon-list-alt"></i><span>Reports</span> </a> </li>
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
<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="span6">
          <div class="widget widget-nopad">
            <div class="widget-header"> <i class="icon-list-alt"></i>
              <h3> Today's Stats</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div class="widget big-stats-container">
                <div class="widget-content">
                  <h6 class="bigstats">Overall stats of Today!</h6>
                  <div id="big_stats" class="cf">
                    <div class="stat">Page views<i class="icon-thumbs-up-alt"></i> <span class="value"><?php echo $today_page; ?></span> </div>
                    <!-- .stat -->
                    
                    <div class="stat">Pastes<i class="icon-file"></i> <span class="value"><?php echo $today_pastes_count; ?></span> </div>
                    <!-- .stat -->
                    
                    <div class="stat">New users<i class="icon-user "></i> <span class="value"><?php echo $today_users_count; ?></span> </div>
                    <!-- .stat -->
                    
                    <div class="stat">Unique Visitors<i class="icon-group"></i> <span class="value"><?php echo $today_visit; ?></span> </div>
                    <!-- .stat --> 
                  </div>
                </div>
                <!-- /widget-content --> 
                
              </div>
            </div>
          </div>
          <!-- /widget -->
         <div class="widget widget-table action-table">
            <div class="widget-header"> <i class="icon-th-list"></i>
              <h3>Recent Pastes</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Paste ID</th>
                    <th>IP</th>
                    <th>Member</th>
                    <th>Date</th>
                    <th>Views</th>
                  </tr>
                </thead>
                <tbody>
                            <?php 
            
   $res = getRecent($con,7);
   while($row = mysqli_fetch_array($res)) {
    $title =  Trim($row['title']);
    $p_id =  Trim($row['id']);
    $p_date = Trim($row['s_date']);
    $p_ip = Trim($row['ip']);
    $p_member = Trim($row['member']);
    $p_view = Trim($row['views']);
    $p_time = Trim($row['now_time']);
    $nowtime = time();
    $oldtime = $p_time;
    $p_time = conTime($nowtime-$oldtime);
    $title = truncate($title, 5, 30);
    echo "
                  <tr>
                    <td>$p_id</td>
                    <td><span class='badge bg-light-blue'>$p_ip</span></td>
                    <td>$p_member</td>
                    <td>$p_date</td>
                    <td>$p_view</td>
                  </tr> "; } ?>
                                 
                </tbody>
              </table>
            </div>
            <!-- /widget-content --> 
          </div>
          <!-- /widget -->
  
     <div class="widget widget-table action-table">
            <div class="widget-header"> <i class="icon-th-list"></i>
              <h3>Admin History</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Last Login Date</th>
                    <th>IP</th>
                  </tr>
                </thead>
                <tbody>
     <?php 
  
  $query =  "SELECT @last_id := MAX(id) admin_history";
    
  $result = mysqli_query($con,$query);
    
  while($row = mysqli_fetch_array($result)) {
  $last_id =  $row['@last_id := MAX(id)'];
  }
  
  for($cloop=0; $cloop<=7; $cloop++)
  {
  $c_my_id = $last_id - $cloop;
  $query =  "SELECT * FROM admin_history WHERE id='$c_my_id'";
  $result = mysqli_query($con,$query);
            
   while($row = mysqli_fetch_array($result)) {
    $last_date =  $row['last_date'];
    $ip =  $row['ip'];
 }
    echo "
                  <tr>
                    <td>$c_my_id</td>
                    <td>$last_date</td>
                    <td><span class='badge bg-black'>$ip</span></td>
                  </tr> ";  
                  }
                  
                   ?>
                                 
                </tbody>
              </table>
            </div>
            <!-- /widget-content --> 
          </div>
          <!-- /widget -->
  
            <!-- /widget --> 
        </div>
        <!-- /span6 -->
        <div class="span6">
          <div class="widget">
            <div class="widget-header"> <i class="icon-bookmark"></i>
              <h3>Important Shortcuts</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <div class="shortcuts"> 
              <a href="manage.php" class="shortcut"><i class="shortcut-icon icon-list-alt"></i><span
              class="shortcut-label">Manage Site</span> </a>
              
              <a href="../archive.php" class="shortcut"><i
              class="shortcut-icon icon-tasks"></i><span class="shortcut-label">Archive</span> 
              
              </a>
              <a href="reports.php" class="shortcut"><i class="shortcut-icon icon-signal"></i> 
              <span class="shortcut-label">Reports</span>
              
               </a><a href="ads.php" class="shortcut"> 
              <i class="shortcut-icon icon-money"></i><span class="shortcut-label">Site Ads</span> </a>
              
              
              <a href="user.php" class="shortcut"><i class="shortcut-icon icon-user"></i><span
              class="shortcut-label">Users</span> </a><a href="pastes.php" class="shortcut"><i
              class="shortcut-icon icon-file"></i><span class="shortcut-label">Pastes</span> </a>
              
              <a href="sitemap.php" class="shortcut"><i class="shortcut-icon icon-sitemap"></i> 
              <span class="shortcut-label">Rebuild Sitemap</span>
              
              </a><a href="pasges.php" class="shortcut"> 
              <i class="shortcut-icon icon-book"></i><span class="shortcut-label">Pages</span> </a> </div>
              <!-- /shortcuts --> 
            </div>
            <!-- /widget-content --> 
          </div>
          <!-- /widget -->
          <div class="widget">
            <div class="widget-header"> <i class="icon-signal"></i>
              <h3> PageViews History</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <canvas id="area-chart" class="chart-holder" height="250" width="538"> </canvas>
              <!-- /area-chart --> 
            </div>
            <!-- /widget-content --> 
          </div>
          <!-- /widget -->
          
  
     <div class="widget widget-table action-table">
            <div class="widget-header"> <i class="icon-th-list"></i>
              <h3>Latest New Users</h3>
            </div>
            <!-- /widget-header -->
            <div class="widget-content">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Date</th>
                    <th>IP</th>
                  </tr>
                </thead>
                <tbody>
                            <?php 
            
    $query =  "SELECT @last_id := MAX(id) FROM users";
    
    $result = mysqli_query($con,$query);
    
    while($row = mysqli_fetch_array($result)) {
    $last_id =  $row['@last_id := MAX(id)'];
    }
  
  for($uloop=0; $uloop<=7; $uloop++)
  {
  $r_my_id = $last_id - $uloop;
  $query =  "SELECT * FROM users WHERE id='$r_my_id'";
  $result = mysqli_query($con,$query);
            
   while($row = mysqli_fetch_array($result)) {
    $u_date =  $row['date'];
    $ip =  $row['ip'];
    $username =  $row['username'];
 }
    echo "
                  <tr>
                    <td>$r_my_id</td>
                    <td>$username</td>
                    <td>$u_date</td>
                    <td><span class='badge bg-purple'>$ip</span></td>
                  </tr> ";  
                  }
                  
                   ?>
                                 
                </tbody>
              </table>
            </div>
            <!-- /widget-content --> 
          </div>
          <!-- /widget -->
          <!-- /widget --> 
        </div>
        <!-- /span6 --> 
      </div>
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /main-inner --> 
</div>
<!-- /main -->
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
<!-- /footer --> 
<!-- Le javascript
================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 
<script src="js/jquery-1.7.2.min.js"></script> 
<script src="js/excanvas.min.js"></script> 
<script src="js/chart.min.js" type="text/javascript"></script> 
<script src="js/bootstrap.js"></script>
<script language="javascript" type="text/javascript" src="js/full-calendar/fullcalendar.min.js"></script>
 
<script src="js/base.js"></script> 
<script>     

        var lineChartData = {
<?php

    echo 'labels: ["'.$ldate[6].'", "'.$ldate[5].'", "'.$ldate[4].'", "'.$ldate[3].'", "'.$ldate[2].'", "'.$ldate[1].'", "'.$ldate[0].'"],
            datasets: [
				{
				    fillColor: "rgba(220,220,220,0.5)",
				    strokeColor: "rgba(220,220,220,1)",
				    pointColor: "rgba(220,220,220,1)",
				    pointStrokeColor: "#fff",
				    data: ['.$tpage[6].', '.$tpage[5].', '.$tpage[4].', '.$tpage[3].', '.$tpage[2].', '.$tpage[1].', '.$tpage[0].']
				},
				{
				    fillColor: "rgba(151,187,205,0.5)",
				    strokeColor: "rgba(151,187,205,1)",
				    pointColor: "rgba(151,187,205,1)",
				    pointStrokeColor: "#fff",
				    data: ['.$tvisit[6].', '.$tvisit[5].', '.$tvisit[4].', '.$tvisit[3].', '.$tvisit[2].', '.$tvisit[1].', '.$tvisit[0].']
				}';
    ?>
			]

        }

        var myLine = new Chart(document.getElementById("area-chart").getContext("2d")).Line(lineChartData);


        var barChartData = {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [
				{
				    fillColor: "rgba(220,220,220,0.5)",
				    strokeColor: "rgba(220,220,220,1)",
				    data: [100, 59, 90, 81, 56, 55, 40]
				},
				{
				    fillColor: "rgba(151,187,205,0.5)",
				    strokeColor: "rgba(151,187,205,1)",
				    data: [28, 48, 40, 19, 96, 27, 100]
				}
			]

        }    
    </script><!-- /Calendar -->
</body>
</html>