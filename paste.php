<?php
session_start();
/*
 * @author Balaji
 */
 
// Disable errors 
error_reporting(1);

//UTF-8
header( 'Content-Type: text/html; charset=utf-8' ); 
  
// required functions
require_once('config.php');
require_once('core/geshi.php');
require_once('core/functions.php');

// Path of GeSHi object
$path = 'core/geshi/';

// GET Paste ID
if (isset($_GET['id']))
{
$paste_id = Trim(htmlspecialchars($_GET['id']));
}
elseif (isset($_POST['id']))
{
$paste_id = Trim(htmlspecialchars($_POST['id']));
}
else
{
    $error = "Paste ID not found";
}
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
die("You have been banned from ".$site_name);
}
 
//Logout
if (isset($_GET['logout']))
{
        unset($_SESSION['token']);
        unset($_SESSION['oauth_uid']);
        unset($_SESSION['username']);
        session_destroy();
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

    $query =  "SELECT * FROM pastes WHERE id='$paste_id'";
    $result = mysqli_query($con,$query);
    if(mysqli_num_rows($result) > 0) 
    {
    $query =  "SELECT * FROM pastes WHERE id='$paste_id'";
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
    }

    $p_private_error = '0';
    if ($p_visible =="2")
    {
    if (isset($_SESSION['username']))
    {
        if ($p_member == Trim($_SESSION['username']))
        {
        }  
        else
        {
        $error = $lang['18']; //" This is a private paste. Only who created can see!";
        $p_private_error = '1';
        goto Not_Valid_Paste;
        }
    }
    else
    {
        $error =$lang['19']; //" This is a private paste. If you created this paste, please login to view it.";
        $p_private_error = '1';
        goto Not_Valid_Paste;
    }
    }    
    if ($p_expiry=="NULL" || $p_expiry=="SELF")
    {}
    else
    {
    $input_time = $p_expiry;
    $current_time = mktime(date("H"),date("i"),date("s"),date("n"),date("j"),date("Y"));
    if ($input_time < $current_time)
    {
    $error = "Paste is expired";
    $p_private_error = 1;
    goto Not_Valid_Paste;
    }
    }
    if ($p_encrypt=="" || $p_encrypt== null || $p_encrypt=='0')
    {
    }
    else
    {
        $p_content = decrypt($p_content);
    }
    $op_content = Trim(htmlspecialchars_decode($p_content));
     
     //Download the Paste   
    if (isset($_GET['download']))
    {
     if ($p_password=="NONE")
    {    
     doDownload($paste_id,$p_title,$op_content,$p_code);
     exit();
    }
    else
    {
        if (isset($_GET['password']))
        {
            if ($_GET['password'] == "$p_password")
            {
            doDownload($paste_id,$p_title,$op_content,$p_code);
            exit();              
            }
            else
            {
            $error = $lang['20']; // 'Wrong Password!';
            }
        }
        else
        {
            $error = $lang['21']; // 'Not allowed! Password Protected paste.';
        }
    }
    } 

			// Preprocess
			$highlight=array();
			$prefix_size=strlen('!highlight!');
			if ($prefix_size)
			{
				$lines=explode("\n",$p_content);
				$p_content="";
				foreach ($lines as $idx=>$line)
				{
					if (substr($line,0,$prefix_size)=='!highlight!')
					{
						$highlight[]=$idx+1;
						$line=substr($line,$prefix_size);
					}
					$p_content.=$line."\n";
				}
				$p_content=rtrim($p_content);
			}

    // Apply syntax highlight
    $p_content = htmlspecialchars_decode($p_content);
    $geshi = new GeSHi($p_content, $p_code, $path);
    $geshi->enable_classes();
    $geshi->set_header_type(GESHI_HEADER_DIV);
   	$geshi->set_line_style('background: #ffffff;', 'background: #F3F3F3;');		
    if (count($highlight))
	{
	$geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);
	$geshi->highlight_lines_extra($highlight);
	$geshi->set_highlight_lines_extra_style('color:black;background:#FFFF88;');
	}
	else
	{
	$geshi->enable_line_numbers(GESHI_FANCY_LINE_NUMBERS,2);
	}                        
    $p_content = $geshi->parse_code();
    $style =$geshi->get_stylesheet();
    $ges_style= '<style>'.$style.'</style>';
    }
    else
    {
    $error = $lang['22'] ; //"Paste not found";
    } 
      
require_once('theme/'.$default_theme.'/header.php');
if ($p_password=="NONE")
{ 

// No password & diplay the paste

//Set Download URL
$p_download = "/paste.php?download&id=$paste_id";

//Theme & Output
require_once('theme/'.$default_theme.'/view.php');
updateMyView($con,$paste_id);
if ($p_expiry=="SELF")
{
deleteMyPaste($con,$paste_id);
}  
} else {
$p_download = "/paste.php?download&id=$paste_id&password=".md5(Trim(htmlspecialchars($_POST['mypass'])));  
// Check password
if(isset($_POST['mypass']))
{
if ($p_password == md5(Trim(htmlspecialchars($_POST['mypass']))))
{
//Theme & Output
require_once('theme/'.$default_theme.'/view.php');
updateMyView($con,$paste_id);
if ($p_expiry=="SELF")
{
deleteMyPaste($con,$paste_id);
} 
}
else
{
    $error = $lang['23']; //"Password is Wrong";
    require_once('theme/'.$default_theme.'/password.php');
}
}
else {
// Display Password Box  
require_once('theme/'.$default_theme.'/password.php');
} 
}

Not_Valid_Paste:
// Private paste not valid
if ($p_private_error == '1')
{  
// Display Error
require_once('theme/'.$default_theme.'/header.php'); 
require_once('theme/'.$default_theme.'/password.php'); 
}

// Footer
require_once('theme/'.$default_theme.'/footer.php'); 
?>