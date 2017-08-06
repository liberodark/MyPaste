<?php
/*
* @author Balaji
*/

// Disable errors
error_reporting(1);

require_once ('config.php');

// Database Connection
$con = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_database);
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
    
$username = htmlentities(trim($_GET['username']));
$code = htmlentities(trim($_GET['code']));

        $query =  "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($con,$query);
        if(mysqli_num_rows($result) > 0) 
        {
        // Username found
        while($row = mysqli_fetch_array($result)) {
        $db_oauth_uid = $row['oauth_uid'];
        $db_email_id = Trim($row['email_id']);
        $db_full_name  = $row['full_name'];
        $db_platform  = $row['platform'];
        $db_password  = Trim($row['password']);
        $db_verified  = $row['verified'];
        $db_picture = $row['picture'];
        $db_date = $row['date'];
        $db_ip = $row['ip'];
        $db_id = $row['id'];
        }
        $ver_code = Md5('4et4$55765'.$db_email_id.'d94ereg'); 
        if ($db_verified == '1')
        {
            die("Account already verified...");
        }  
        if ($ver_code == $code) 
        {
        $query = "UPDATE users SET verified='1' WHERE username='$username'";
        mysqli_query($con,$query);
        if(mysqli_error($con))
        {
        $error = "Something Went Wrong! Contact Support!";
        }
        else
        {
            echo "Account verified successfully.. <br /> <br /> You can login now..";
            header("Location: index.php");
            echo '<meta http-equiv="refresh" content="1;url=index.php">';
            exit();
        }    
        }
        else
        {echo $ver_code;
        die("Verification code is wrong..");
        }
        }
        else
        {
            die("Username not found");
        }
?>