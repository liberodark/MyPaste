<?php
session_start();
/*
* @author Balaji
*/

// Disable errors
error_reporting(1);

// required functions
require_once ('config.php');
require_once ('core/functions.php');
require_once ('mail/mail.php');

// Current Date & User IP
$date = date('jS F Y');
$ip = $_SERVER['REMOTE_ADDR'];
$data_ip = file_get_contents('core/temp_cal.tdata');

//Mail
$mail_type = "2";

//Check already login
if(isset($_SESSION['token']))
{
    header("Location: /index.php");
    echo '<meta http-equiv="refresh" content="1;url=/index.php">';
    $success = "You are already logged in";
}

// Database Connection
$con = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_database);
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
    
    $admin_mail = $email;
    $admin_name = $site_name;
    
    // SMTP information
    
        $query =  "SELECT * FROM mail WHERE id='1'";
        $result = mysqli_query($con,$query);
        
        while($row = mysqli_fetch_array($result)) {
        $smtp_host =   Trim($row['smtp_host']);
        $smtp_user =  Trim($row['smtp_username']);
        $smtp_pass =  Trim($row['smtp_password']);
        $smtp_port =  Trim($row['smtp_port']);
        $protocol =  Trim($row['protocol']);
        $smtp_auth =  Trim($row['auth']);
        $smtp_sec =  Trim($row['socket']);
        }
        $mail_type = $protocol;
    
    // Set theme and lang
    $query =  "SELECT * FROM interface";
    $result = mysqli_query($con,$query);
        
    while($row = mysqli_fetch_array($result)) {
    $default_lang =  Trim($row['lang']);
    $default_theme =   Trim($row['theme']);
    }
    require_once("langs/$default_lang");
    
//Page Title
$p_title = $lang['login/register']; //"Login/Register";

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
//Logout
if (isset($_GET['logout']))
{
        unset($_SESSION['token']);
        unset($_SESSION['oauth_uid']);
        unset($_SESSION['username']);
        session_destroy();
}

if (strpos($banned_ip,$ip) !== false)
{
die($lang['banned']); //"You have been banned from ".$site_name
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
if (isset($_GET['resend']))
{          
    if (isset($_POST['email']))
    {
        $email = htmlentities(trim($_POST['email']));
        $query =  "SELECT * FROM users WHERE email_id='$email'";
        $result = mysqli_query($con,$query);
        if(mysqli_num_rows($result) > 0) 
        {
        // Username found
        while($row = mysqli_fetch_array($result)) {
        $username = $row['username'];
        $db_email_id = $row['email_id'];
        $db_full_name  = $row['full_name'];
        $db_platform  = $row['platform'];
        $db_password  = Trim($row['password']);
        $db_verified  = $row['verified'];
        $db_picture = $row['picture'];
        $db_date = $row['date'];
        $db_ip = $row['ip'];
        $db_id = $row['id'];
        }
        if ($db_verified == '0')
        {
          $verify_url = 'http://' . $_SERVER['HTTP_HOST'] . "/verify.php?username=$username&code=".Md5('4et4$55765'.$db_email_id.'d94ereg');
          $sent_mail =  $email;
          $subject = $lang['mail_acc_con']; // "$site_name Account Confirmation";
          $body = "<br />
          Welcome and thank you for registering at $site_name <br /><br />
          
          If you are the creator of the $site_name account, please click your activation url: <br />
          
          <a href='$verify_url' target='_self'>$verify_url</a>  <br /> <br />
          
          After account confirmation, You can log in by using your username and password by visiting our website. <br /> <br />
          
          Thank you,<br />
            - The $site_name Team
          ";
      
          if ($mail_type == '1')
        {
          default_mail ($admin_mail,$admin_name,$sent_mail,$subject,$body);
        }
        else
        {
          smtp_mail($smtp_host,$smtp_port,$smtp_auth,$smtp_user,$smtp_pass,$smtp_sec,$admin_mail,$admin_name,$sent_mail,$subject,$body);
        }
          $success = $lang['mail_suc']; // "Activation code successfully sent to your mail id";    
          
        }
        else
        {
                $error = $lang['email_ver']; //"Email ID already verified!";    
        }

        }
        else
        {
        $error =  $lang['email_not']; // "Email ID not found!";
        }
    
}
}

if (isset($_GET['forget']))
{
    if (isset($_POST['email']))
    {
        $email = htmlentities(trim($_POST['email']));
        $query =  "SELECT * FROM users WHERE email_id='$email'";
        $result = mysqli_query($con,$query);
        if(mysqli_num_rows($result) > 0) 
        {
        // Username found
        while($row = mysqli_fetch_array($result)) {
        $username = $row['username'];
        $db_email_id = $row['email_id'];
        $db_full_name  = $row['full_name'];
        $db_platform  = $row['platform'];
        $db_password  = Trim($row['password']);
        $db_verified  = $row['verified'];
        $db_picture = $row['picture'];
        $db_date = $row['date'];
        $db_ip = $row['ip'];
        $db_id = $row['id'];
        }
        $new_pass = md5(uniqid(rand(), true));  
        $new_pass_md5 = md5($new_pass);
        
        $query = "UPDATE users SET password='$new_pass_md5' WHERE username='$username'";
        mysqli_query($con,$query);
        if(mysqli_error($con))
        {
        $error = "Unable to post on database! Contact Support!";
        }
        else
        {
        $success = $lang['pass_change']; //"Password changed successfully and Sent to your mail";
          $sent_mail =  $email;
          $subject = "$site_name Password Reset";
          $body = "<br />
          Hello, <br /><br />
          
          Recently your account password has been reset by your request. Please take new password to login. <br /><br />
          
          Your New Password:  $new_pass  <br /> <br />
          
          You can log in by using your username and new password by visiting our website. <br /> <br />
          
          Thank you,<br />
            - The $site_name Team
          ";
          if ($mail_type == '1')
        {
          default_mail ($admin_mail,$admin_name,$sent_mail,$subject,$body);
        }
        else
        {
          smtp_mail($smtp_host,$smtp_port,$smtp_auth,$smtp_user,$smtp_pass,$smtp_sec,$admin_mail,$admin_name,$sent_mail,$subject,$body);
        }
        
        }
        
        }
        else
        {
        $error = $lang['email_not']; //"Email ID not found!";  
        }
    
    }
    
}
if ($_SERVER['REQUEST_METHOD'] == POST)
{
    //Already login
    if(isset($_SESSION['token']))
    {
    header("Location: /index.php");
    echo '<meta http-equiv="refresh" content="1;url=/index.php">';
    $success = "You are already logged in";
    }else{
    // Login process
    if (isset($_POST['signin']))
    {
        $username = htmlentities(trim($_POST['username']));
        $password = Md5(htmlentities(trim($_POST['password'])));
        if ($username != null && $password!= null)
        {
        
        $query =  "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($con,$query);
        if(mysqli_num_rows($result) > 0) 
        {
        // Username found
        while($row = mysqli_fetch_array($result)) {
        $db_oauth_uid = $row['oauth_uid'];
        $db_email_id = $row['email_id'];
        $db_full_name  = $row['full_name'];
        $db_platform  = $row['platform'];
        $db_password  = Trim($row['password']);
        $db_verified  = $row['verified'];
        $db_picture = $row['picture'];
        $db_date = $row['date'];
        $db_ip = $row['ip'];
        $db_id = $row['id'];
        }

        if ($password == "$db_password")
        {
        if ($db_verified == "1")
        { 
            // Login Success
            $_SESSION['token'] = Md5($db_id.$username);
            $_SESSION['oauth_uid'] = $db_oauth_uid;
            $_SESSION['username'] = $username;
            
            $success = $lang['3']; //"Login Successful..";
        }
        elseif ($db_verified == "2")
        {
        // Account not verified
         $error = $lang['1']; //"Oh, no your account was banned! Contact Support..";
        }
        else
        {
        // Account not verified
         $error = $lang['2']; //"Oh, no account not verified";
        }              
        }
        else
        {
                // Password wrong
            $error = $lang['4']; // "Oh, no password is wrong";
            
        }
        }
        else
        {
        // Username not found
            $error = $lang['5']; // "Username not found";
        }
        }
        else
        {
        $error = $lang['6']; //"All fields must be filled out!";
        }
    }
    
    // Register process
        if (isset($_POST['signup']))
    {
        $username = htmlentities(trim($_POST['username']));
        $password = Md5(htmlentities(trim($_POST['password'])));
        $email = htmlentities(trim($_POST['email']));
        $full_name = htmlentities(trim($_POST['full']));
         if ($username != null && $password!= null && $full_name!=null && $email!= null)
        {
                $res= isValidUsername($username);
        if ($res == '1')
        {
        $query =  "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($con,$query);
        if(mysqli_num_rows($result) > 0)  
        {
            $error = $lang['7']; // "Username already taken";
        }
        else
        {
                   
        $query =  "SELECT * FROM users WHERE email_id='$email'";
        $result = mysqli_query($con,$query);
        if(mysqli_num_rows($result) > 0) 
        {
            $error = $lang['8']; // "Email ID already registered";
        }
        else
        {
        $query = "INSERT INTO users (oauth_uid,username,email_id,full_name,platform,password,verified,picture,date,ip) VALUES ('0','$username','$email','$full_name','Direct','$password','0','NONE','$date','$ip')"; 
        mysqli_query($con,$query); 
        if (mysqli_error($con))
        $error = "Database Error";
        else
        {
        $success = $lang['9'] ; // "Your account was successfully registered";
        $verify_url = 'http://' . $_SERVER['HTTP_HOST'] . "/verify.php?username=$username&code=".Md5('4et4$55765'.$email.'d94ereg');
          $sent_mail =  $email;
          $subject = $lang['mail_acc_con']; // "$site_name Account Confirmation";
          $body = "<br />
          Welcome and thank you for registering at $site_name <br /><br />
          
          If you are the creator of the $site_name account, please click your activation url: <br />
          
          <a href='$verify_url' target='_self'>$verify_url</a>  <br /> <br />
          
          After account confirmation, You can log in by using your username and password by visiting our website. <br /> <br />
          
          Thank you,<br />
            - The $site_name Team
          ";
        if ($mail_type == '1')
        {
          default_mail ($admin_mail,$admin_name,$sent_mail,$subject,$body);
        }
        else
        {
          smtp_mail($smtp_host,$smtp_port,$smtp_auth,$smtp_user,$smtp_pass,$smtp_sec,$admin_mail,$admin_name,$sent_mail,$subject,$body);
        }
        }
        }
        
        }
    }
    else
    {
    $error = $lang['10']; // "Username not valid! Username can't contain special characters..";
    }
    }
    else
    {
        $error = $lang['11']; // "All fields must be filled out!";
    }
    }
    }
}

//Theme & Output
require_once('theme/'.$default_theme.'/header.php');
require_once('theme/'.$default_theme.'/login.php');
require_once('theme/'.$default_theme.'/footer.php');
?>