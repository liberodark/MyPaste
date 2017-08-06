<?php
session_start();
/*
 * @author Balaji
 */
 
// Disable errors 
error_reporting(1);


$filename = 'install.php';

if (file_exists($filename)) {
    echo "Install.php file exists! <br /> <br />  Redirecting to installer panel...";
    header("Location: install.php");
    echo '<meta http-equiv="refresh" content="1;url=install.php">';
    exit();
} 

// required functions
require_once('config.php');
require_once("core/cap.php");
require_once('core/functions.php');

//UTF-8
header( 'Content-Type: text/html; charset=utf-8' ); 

// Database Connection
$con = mysqli_connect($mysql_host,$mysql_user,$mysql_pass,$mysql_database);
if (mysqli_connect_errno())
{
die("Unable connect to database");
}

//Get site Info
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
    $ga  =   Trim($row['ga']);
    }

    // Set theme and lang
    $query =  "SELECT * FROM interface";
    $result = mysqli_query($con,$query);
        
    while($row = mysqli_fetch_array($result)) {
    $default_lang =  Trim($row['lang']);
    $default_theme =   Trim($row['theme']);
    }
    require_once("langs/$default_lang");
    
// Current Date & User IP
$date = date('jS F Y');
$ip = $_SERVER['REMOTE_ADDR'];
$data_ip = file_get_contents('core/temp_cal.tdata');

// Ads
$query =  "SELECT * FROM ads WHERE id='1'";
$result = mysqli_query($con,$query);
        
while($row = mysqli_fetch_array($result)) {
$text_ads =  Trim($row['text_ads']);
$ads_1 =  Trim($row['ads_1']);
$ads_2 =  Trim($row['ads_2']);
}  

// Banned IP's Checking! 
$query =  "SELECT * FROM ban_user";
$result = mysqli_query($con,$query);
        
while($row = mysqli_fetch_array($result)) {
$banned_ip =  $banned_ip."::".$row['ip'];
}
if (strpos($banned_ip,$ip) !== false)
{
die($lang['banned']); // "You have been banned from ".$site_name;
}
    $query = "Select * From sitemap_options WHERE id='1'"; 
    $result = mysqli_query($con,$query); 
    
    while($row = mysqli_fetch_array($result)) {
    $priority =  $row['priority'];
    $changefreq =  $row['changefreq'];
    }
    
    $query =  "SELECT * FROM capthca where id='1'";
    $result = mysqli_query($con,$query);
       	 	 	 	   
    while($row = mysqli_fetch_array($result)) {
    $color =  Trim($row['color']);
    $mode =   Trim($row['mode']);
    $mul =  Trim($row['mul']);
    $allowed =   Trim($row['allowed']);
    $cap_e = Trim($row['cap_e']);
    }
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{  
}
else
{
if ($cap_e == "on")
{
  $_SESSION['captcha'] = elite_captcha($color,$mode,$mul,$allowed);    
} 
}
// Escape from quotes
if (get_magic_quotes_gpc())
{
	function callback_stripslashes(&$val, $name) 
	{
		if (get_magic_quotes_gpc()) 
			$val=stripslashes($val);
	}
	if (count($_GET))
		array_walk ($_GET, 'callback_stripslashes');
	if (count($_POST))
		array_walk ($_POST, 'callback_stripslashes');
	if (count($_COOKIE))
		array_walk ($_COOKIE, 'callback_stripslashes');
}

//Logout
if (isset($_GET['logout']))
{
        unset($_SESSION['token']);
        unset($_SESSION['oauth_uid']);
        unset($_SESSION['username']);
        unset($_SESSION['pic']);
        session_destroy();
}

// Page View  
    $query =  "SELECT @last_id := MAX(id) FROM page_view";
    
    $result = mysqli_query($con,$query);
    
    while($row = mysqli_fetch_array($result)) {
    $last_id =  $row['@last_id := MAX(id)'];
    }
    
    $query =  "SELECT * FROM page_view WHERE id=".Trim($last_id);
    $result = mysqli_query($con,$query);
        
    while($row = mysqli_fetch_array($result)) {
    $last_date =  $row['date'];
    }
    
    if($last_date == $date)
    {
         if (str_contains($data_ip, $ip)) 
        {
          $query =  "SELECT * FROM page_view WHERE id=".Trim($last_id);
          $result = mysqli_query($con,$query);
        
        while($row = mysqli_fetch_array($result)) {
        $last_tpage =  Trim($row['tpage']);
            }
        $last_tpage = $last_tpage +1;
        
          // Already IP is there!  So update only page view.
        $query = "UPDATE page_view SET tpage=$last_tpage WHERE id=".Trim($last_id);
        mysqli_query($con,$query);
        }
        else
        {
        $query =  "SELECT * FROM page_view WHERE id=".Trim($last_id);
        $result = mysqli_query($con,$query);
        
        while($row = mysqli_fetch_array($result)) {
        $last_tpage =  Trim($row['tpage']);
        $last_tvisit =  Trim($row['tvisit']);
        }
        $last_tpage = $last_tpage +1;
        $last_tvisit = $last_tvisit +1;
        
        // Update both tpage and tvisit.
        $query = "UPDATE page_view SET tpage=$last_tpage,tvisit=$last_tvisit WHERE id=".Trim($last_id);
        mysqli_query($con,$query);
        file_put_contents('core/temp_cal.tdata',$data_ip."\r\n".$ip); 
        }
    }
    else
    { 
    //Delete the file and clear data_ip
    unlink("core/temp_cal.tdata");
    $data_ip ="";
    
    // New date is created!
    $query = "INSERT INTO page_view (date,tpage,tvisit) VALUES ('$date','1','1')"; 
    mysqli_query($con,$query);
    
    //Update the IP!
    file_put_contents('core/temp_cal.tdata',$data_ip."\r\n".$ip); 
    
}

// POST Handler
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // Check POST data status 
    if (isset($_POST['title']) And isset($_POST['paste_data']))
    {
    if ($cap_e == "on")
    {
    $scode = strtolower(htmlentities(Trim($_POST['scode'])));
    $cap_code = strtolower($_SESSION['captcha']['code']);
    if ($cap_code == $scode)
    {
    }
    else
    {
        $error = $lang['image_wrong'];  //Your image verification code is wrong!
        goto OutPut;
    }
    }
    $p_title = Trim(htmlspecialchars($_POST['title']));
    $p_content = htmlspecialchars($_POST['paste_data']);
    $p_visible = Trim(htmlspecialchars($_POST['visibility']));
    $p_code = Trim(htmlspecialchars($_POST['format']));
    $p_expiry = Trim(htmlspecialchars($_POST['paste_expire_date']));
    $p_password = Trim(htmlspecialchars($_POST['pass']));
    if ($p_password=="" || $p_password==null)
    {
        $p_password = "NONE";
    }else
    {
        $p_password = Md5($p_password);
    }
    $p_encrypt = Trim(htmlspecialchars($_POST['encrypted'])); 
    
    if ($p_encrypt=="" || $p_encrypt== null)
    {
        $p_encrypt= "0";
    }
    else
    {
        // Encrypt Option
        $p_encrypt= "1";
        $p_content = encrypt($p_content);
    }
     
    if (isset($_SESSION['token']))
    {
         $p_member =  Trim($_SESSION['username']);
    } 
    else
    {
        $p_member =  "Guest";
    }
   	//Set expiry time
    	switch ($p_expiry)
    	{
  			case '10M':
  	            $expires=mktime (date("H"),date("i")+"10",date("s"),date("n"),date("j"),date("Y"));
				break;
 			case '1H':
  	            $expires=mktime (date("H")+"1",date("i"),date("s"),date("n"),date("j"),date("Y"));
    		case '1D':
    			$expires=mktime (date("H"),date("i"),date("s"),date("n"),date("j")+"1",date("Y"));
    			break;
			case '1W':
  	            $expires=mktime (date("H"),date("i"),date("s"),date("n"),date("j")+"7",date("Y"));
				break;
 			case '2W':
  	            $expires=mktime (date("H"),date("i"),date("s"),date("n"),date("j")+"14",date("Y"));
				break;
 			case '1M':
  	            $expires=mktime (date("H"),date("i"),date("s"),date("n")+"1",date("j"),date("Y"));
				break;
 			case 'self':
  	            $expires="SELF";
				break;
 			case 'N':
			    $expires="NULL";
				break;
			default:
			     $expires="NULL";
    			break;	
    	}
    $p_content =  mysqli_real_escape_string($con,$p_content);
    $p_date = date('jS F Y h:i:s A');
    $date = date('jS F Y');
    $now_time = mktime (date("H"),date("i"),date("s"),date("n"),date("j"),date("Y"));
    $query =  "INSERT INTO pastes (title,content,visible,code,expiry,password,encrypt,member,date,ip,now_time,views,s_date) VALUES 
    ('$p_title','$p_content','$p_visible','$p_code','$expires','$p_password','$p_encrypt','$p_member','$p_date','$ip','$now_time','0','$date')"; 
    $result = mysqli_query($con,$query);
    if(mysqli_error($con))
    {
        $error =  $lang['paste_db_error']; //"Unable to post the paste on database";
    }
    else
    {
    $query =  "SELECT @last_id := MAX(id) FROM pastes";
    $result = mysqli_query($con,$query);
    while($row = mysqli_fetch_array($result)) {
    $paste_id =  $row['@last_id := MAX(id)'];
    }
    $success =  $paste_id;
    if ($p_visible == '0')
    {
           addToSitemap($paste_id,$priority,$changefreq,$mod_rewrite); 
    }
    }
    }
    else
    {
       $error =  $lang['error']; // "Something Went Wrong";
    }
}

OutPut:    
//Theme & Output
require_once('theme/'.$default_theme.'/header.php');
require_once('theme/'.$default_theme.'/main.php');
require_once('theme/'.$default_theme.'/footer.php');
?>