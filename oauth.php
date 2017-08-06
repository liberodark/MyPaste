<?php
session_start();
/*
 * @author Balaji
 */
error_reporting(1);

// required functions
require_once ('config.php');
require_once ('core/functions.php');

// Current Date & User IP
$date = date('jS F Y');
$ip = $_SERVER['REMOTE_ADDR'];

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
    
    // Set theme and lang
    $query =  "SELECT * FROM interface";
    $result = mysqli_query($con,$query);
        
    while($row = mysqli_fetch_array($result)) {
    $default_lang =  Trim($row['lang']);
    $default_theme =   Trim($row['theme']);
    }
    
     require_once("langs/$default_lang");
    
//Page Title
$p_title = $lang['login/register']; // "Login/Register";

if(isset($_GET['new_user']))
{
    $new_user = 1;
}

$username = $_SESSION['username'];

// POST Handler
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (isset($_POST['user_change']))
    {
        $new_username = htmlentities(Trim($_POST['new_username']));
        if ($new_username == "" || $new_username == null)
        {
            $error =  $lang['17']; //"Username not vaild";
        }
        else
        {    
        $res= isValidUsername($new_username);
        if ($res == '1')
        {
        $query =  "SELECT * FROM users WHERE username='$new_username'";
        $result = mysqli_query($con,$query);
        if(mysqli_num_rows($result) > 0)  
        {
            $error = $lang['14']; //"Username already taken";
        }
        else
        {
        $client_id = Trim($_SESSION['oauth_uid']);
        $query = "UPDATE users SET username='$new_username' WHERE oauth_uid='$client_id'";
        mysqli_query($con,$query);
        if(mysqli_error($con))
        {
        $error =  $lang['15']; // "Unable to post on database! Contact Support!";
        }
        else
        {
            $success = $lang['16']; //"Username changed successfully";
            unset($_SESSION['username']);
            $_SESSION['username'] = $new_username;
        }
        }
        }
        else
        {
            $error = $lang['17']; //"Username not vaild";
            $username = Trim($_SESSION['username']);
            goto OutPut;
        }
        }
    }
}

OutPut:
//Theme & Output
require_once('theme/'.$default_theme.'/header.php');
require_once('theme/'.$default_theme.'/oauth.php');
require_once('theme/'.$default_theme.'/footer.php');
?>