<?php
/**
 * @author Balaji
 * @copyright 2017
 */
error_reporting(1);

$date = date('jS F Y');
$ip = $_SERVER['REMOTE_ADDR'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Install - MyPasteBox</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="admin/css/bootstrap.min.css" rel="stylesheet">
<link href="admin/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
<link href="admin/css/font-awesome.css" rel="stylesheet">
<link href="admin/css/style.css" rel="stylesheet">
<link href="admin/css/pages/dashboard.css" rel="stylesheet">
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
 <script>
function loadXMLDoc()
{
var xmlhttp;
var sql_host = $('input[name=data_host]').val();
var sql_name = $('input[name=data_name]').val();
var sql_user = $('input[name=data_user]').val();
var sql_pass = $('input[name=data_pass]').val();
var sql_sec = $('input[name=data_sec]').val();
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    }
  }
$.post("process.php", {data_host:sql_host,data_name:sql_name,data_user:sql_user,data_pass:sql_pass,data_sec:sql_sec}, function(results){
if (results == 0) {
     $("#alert1").show();
     $("#index_1").show();
     $("#index_2").hide();
}
else
{
     $("#alert1").hide();
     $("#alert2").show();
     $("#index_1").hide();
     $("#index_2").show();
}
});
}
</script>   

<script>
function findoc()
{
var xmlhttp;
var user = $('input[name=admin_user]').val();
var pass = $('input[name=admin_pass]').val();
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    }
  }
$("#alert1").hide();
$("#alert2").hide();
$("#index_1").hide();
$("#index_2").hide();
$("#pre_load").show();
$.post("finish.php", {admin_user:user,admin_pass:pass}, function(results){
     $("#index_3").show();
     $("#index_3").append(results);
     $("#pre_load").hide();
});
}
</script>   
  
<style>
 #alert1{ display:none; }
 #alert2{ display:none; }
 #index_2{ display:none; }
 #index_3{ display:none; }
 #pre_load{ display:none; }
  </style>     
    
</head>
<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="install.php">MyPasteBox </a>
      <div class="nav-collapse">
        <ul class="nav pull-right">
          <li class="dropdown"><a href="http://prothemes.biz" class="dropdown-toggle" data-toggle="dropdown">
          Get more PHP script's</a>
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
        <li><a href="install.php"><i class="icon-wrench"></i><span>Installer panel</span> </a> </li> 
        <li></li>
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
?>    

<div class="main">
	
	<div class="main-inner">

	    <div class="container">
	
	      <div class="row">
	      	
	      	<div class="span12">      		
	      		
	      		<div class="widget ">
	      			
	      			<div class="widget-header">
	      				<i class="icon-wrench"></i>
	      				<h3>Install</h3>
	  				</div> <!-- /widget-header -->
					
					<div class="widget-content">
				 <div id="alert1">   
               <div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
                                        <b>Alert!</b> Database connection failed.
                                    </div>
              </div>
              <div id="alert2">  
              <div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
                                        <b>Alert!</b> Database connection success.
              </div>  
              </div>
<div id="index_1">    

                            <div class="box"><br />
                                <div class="box-header">
                                    <h3 class="box-title">Writable file status</h3>
        
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover">
                                        <tbody><tr>
                                            <th>#</th>
                                            <th>File / Folder name</th>
                                            <th>Status</th>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>config.php</td>
                                            
                                         <?php   
                                         $filename = 'config.php';
                                         if (is_writable($filename)) {
    echo '<td><span class="label label-success">Writable</span></td>';
} else {
    echo '<td><span class="label label-danger">Not Writable</span></td>';
}

?>

                                            
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>temp</td>
 <?php   
                                         $filename = 'temp';
                                         if (is_writable($filename)) {
    echo '<td><span class="label label-success">Writable</span></td>';
} else {
    echo '<td><span class="label label-danger">Not Writable</span></td>';
}

?>
                                        </tr>
                                    </tbody></table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

             <div class="box box-primary"><br />
                                <div class="box-header">
                                    <h3 class="box-title">Database Connection</h3>
                                </div><!-- /.box-header --><br />
                                <!-- form start -->
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="data_host">Database Host</label>
                                            <input type="text" placeholder="Enter database name" name="data_host" id="data_host" class="span6">
                                        </div>
                                        <div class="form-group">
                                            <label for="data_name">Database Name</label>
                                            <input type="text" placeholder="Enter database name" name="data_name" id="data_name" class="span6">
                                        </div>
                                        <div class="form-group">
                                            <label for="data_user">Database Username</label>
                                            <input type="text" placeholder="Enter database username" name="data_user" id="data_user" class="span6">
                                        </div>
                                        <div class="form-group">
                                            <label for="data_pass">Database Password</label>
                                            <input type="password" placeholder="Enter database password" name="data_pass" id="data_pass" class="span6">
                                        </div>
                                        
                                    <div class="box-header"> <br />
                                    <h3 class="box-title">Paste encryption key</h3>
                                        </div><!-- /.box-header --> <br />
                                
                                        <div class="form-group">
                                            <label for="data_pass">Encryption Key (Don't forget to copy encryption key in a safe place)</label>
                                            <input style="  background-color: #EEEEEE;
    border-color: #DDDDDD;" readonly="" type="text" value="<?php echo md5(uniqid(rand(), true)); ?>" placeholder="" name="data_sec" id="data_sec" class="span6">
                                        </div>
                                        
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">                                   
                                              <button class="btn btn btn-primary" onclick="loadXMLDoc()" >Submit</button>
                                    </div>

                            </div>
                               </div>
                               
                               
 <div id="index_2">  
       <div class="box box-primary"><br />
                                <div class="box-header">
                                    <h3 class="box-title">Admin Details</h3>  
                                </div><!-- /.box-header --><br />
                                <!-- form start -->
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="admin_user">Admin Username</label>
                                            <input type="text" placeholder="Enter admin username" name="admin_user" id="admin_user" class="span6">
                                        </div>
                                        <div class="form-group">
                                            <label for="admin_pass">Admin Password</label>
                                            <input type="password" placeholder="Enter admin password" name="admin_pass" id="admin_pass" class="span6">
                                        </div>
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">                                   
                                           <button class="btn btn btn-primary" onclick="findoc()" >Submit</button>
                                    </div>

                            </div>
    </div>
         <div id="pre_load">
         <center> <img title="Loading" alt="Loading" src="admin/img/load.gif"/>
                  <br /> <br />
                  Installing.....
         </center>  
       </div>
       
     <div id="index_3">  
       </div>
                            
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
        <div class="span12"> &copy; 2017 MyPasteBox - <a href="http://prothemes.biz/">ProThemes.Biz</a>. </div>
        <!-- /span12 --> 
      </div>
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /footer-inner --> 
</div>
    


<script src="admin/js/jquery-1.7.2.min.js"></script>
	
<script src="admin/js/bootstrap.js"></script>
<script src="admin/js/base.js"></script>


  </body>

</html>
