<?php
session_start();
/*
 * @author Balaji
 */
error_reporting(1);
require_once('config.php');
require_once('core/functions.php');

//UTF-8
header( 'Content-Type: text/html; charset=utf-8' ); 

$date = date('jS F Y');
$ip = $_SERVER['REMOTE_ADDR'];
$data_ip = file_get_contents('core/temp_cal.tdata');
$con = mysqli_connect($mysql_host,$mysql_user,$mysql_pass,$mysql_database);

  if (mysqli_connect_errno())
  {
    die("Unable connect to database");
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
    
    $p_title = $lang['24']; //"My Profile";
    
    $query =  "SELECT * FROM ban_user";
    $result = mysqli_query($con,$query);
        
    while($row = mysqli_fetch_array($result)) {
    $banned_ip =  $banned_ip."::".$row['ip'];
    }
    if (strpos($banned_ip,$ip) !== false)
    {
    die("You have been banned from ".$site_name);
    }
//Check already login
if(isset($_SESSION['token']))
{
}
else
{
    header("Location: /index.php");
    echo '<meta http-equiv="refresh" content="1;url=/index.php">';
    die("You must logged in to access the page..");
}

//Logout
if (isset($_GET['logout']))
{
        unset($_SESSION['token']);
        unset($_SESSION['oauth_uid']);
        unset($_SESSION['username']);
        session_destroy();
}


  $user_username =  htmlentities(Trim($_SESSION['username']));
  $query =  "SELECT * FROM users WHERE username='$user_username'";
  $result = mysqli_query($con,$query);
  while($row = mysqli_fetch_array($result)) {
    $user_oauth_uid = $row['oauth_uid'];
    $user_id = $row['id'];
    $user_email_id  = $row['email_id'];
    $user_full_name  = $row['full_name'];
    $user_platform  = Trim($row['platform']);
    $user_verified  = $row['verified'];
    $user_date = $row['date'];
    $user_ip = $row['ip'];
    $user_password = $row['password'];
    }
    if ($user_oauth_uid == '0')
    {
        $user_oauth_uid = "None";
    }
    
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (isset($_POST['cpassword']))
  {
    $user_new_full = Trim(htmlspecialchars($_POST['full']));
    $user_old_pass = Md5(Trim(htmlspecialchars($_POST['old_password'])));
    $user_new_pass = Md5(Trim(htmlspecialchars($_POST['password'])));
    $user_new_cpass = Md5(Trim(htmlspecialchars($_POST['cpassword'])));
    if ($user_password == $user_old_pass)
    {
    $query =  "UPDATE users SET full_name='$user_new_full', password='$user_new_cpass' WHERE username='$user_username'";
    $result = mysqli_query($con,$query);
    if (mysqli_errno($con)) {
    $success = $lang['25']; //"  Unable to update the profile information ";
    }
    else
    {
      $success = $lang['26']; //"  Your profile information is updated ";  
    }
    }   
    else
    {
    $error =  $lang['27']; // "  Your old password is wrong!";
    }
    
  } 
  else
  {
    $error = $lang['error']; //"Something Went Wromg..!";
  } 

    
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
    $total_pastes = getTotalPastes($con,$user_username);
    
        $query =  "SELECT * FROM ads WHERE id='1'";
        $result = mysqli_query($con,$query);
        
        while($row = mysqli_fetch_array($result)) {
        $text_ads =  Trim($row['text_ads']);
        $ads_1 =  Trim($row['ads_1']);
        $ads_2 =  Trim($row['ads_2']);
        
    }    
//Theme & Output
require_once('theme/'.$default_theme.'/header.php');
require_once('theme/'.$default_theme.'/profile.php');
require_once('theme/'.$default_theme.'/footer.php');  
?>