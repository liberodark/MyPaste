<?php
session_start();
/*
 * @author Balaji
 */
require_once('facebook/autoload.php');
require_once('../config.php');

// Current Date & User IP
$date = date('jS F Y');
$ip = $_SERVER['REMOTE_ADDR'];

// Database Connection
$con = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_database);
if (mysqli_connect_errno())
{
    die("Unable connect to database");
}

//Redirect URL
$protocol = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://';
$fb_redirect_url = $protocol.$_SERVER["HTTP_HOST"].'/oauth/facebook.php';

$fb = new Facebook\Facebook(array(
  'app_id' => FB_APP_ID,
  'app_secret' => FB_APP_SECRET
));


if(isset($_GET['login'])){
    
    // Get the FacebookRedirectLoginHelper
    $helper = $fb->getRedirectLoginHelper();
    
    $permissions = array('email'); // optional
    $loginUrl = $helper->getLoginUrl($fb_redirect_url, $permissions);
    header('Location: '. $loginUrl);
    exit();
    
}else{
    
    // Get the FacebookRedirectLoginHelper
    $helper = $fb->getRedirectLoginHelper();
    
    try {
        $accessToken = $helper->getAccessToken($fb_redirect_url);
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        // When Graph returns an error
        //echo 'Graph returned an error: ' . $e->getMessage();
        //exit;
        die("There was an error.");
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
        // When validation fails or other local issues
        //echo 'Facebook SDK returned an error: ' . $e->getMessage();
        //exit;
        die("There was an error.");
    }
    
    
    if (isset($accessToken)) {
        // Logged in
        
        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get('/me?fields=id,name,email,first_name,last_name', $accessToken);
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            //echo 'Graph returned an error: ' . $e->getMessage();
            //exit;
            die("There was an error.");
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            //echo 'Facebook SDK returned an error: ' . $e->getMessage();
            //exit;
            die("There was an error.");
        }
        
        // Returns a `Facebook\GraphNodes\GraphUser` collection
        $user = $response->getGraphUser();
        
        if (!empty($user)){
            $client_name = $user['name'];
            $client_id = $user['id'];
            $client_email = $user['email'];
            $client_plat = 'Facebook';
            $client_pic = '';
            
            $query = mysqli_query($con,"SELECT * FROM users WHERE oauth_uid='$client_id'");
            if(mysqli_num_rows($query) > 0){
              $query =  "SELECT * FROM users WHERE oauth_uid='$client_id'";
              $result = mysqli_query($con,$query);
              while($row = mysqli_fetch_array($result)) {
                  $user_username  = $row['username'];
                  $db_verified  = $row['verified'];
              }
              
              if ($db_verified == "2")
              {
                die("Oh, no your account was banned! Contact Support..");
              }
              else
              { 
              $_SESSION['username'] = $user_username;
              $_SESSION['token'] = Md5($db_id.$username);
              $_SESSION['oauth_uid'] = $client_id;
              $_SESSION['pic'] = $client_pic;
              
              $old_user =1;
              header("Location: ../index.php");
              exit();
              }
            } else {
              $new_user= 1;
              #user not present.
              $query =  "SELECT @last_id := MAX(id) FROM users";
              $result = mysqli_query($con,$query);
              while($row = mysqli_fetch_array($result)) {
              $last_id =  $row['@last_id := MAX(id)'];
              }
              if ($last_id== "" || $last_id==null)
              {
                  $username = "User1";
              }
              else
              {
                  $last_id = $last_id+1;  
                  $username = "User$last_id";
              }
              $_SESSION['username'] = $username;
               $_SESSION['oauth_uid'] = $client_id;
              $_SESSION['token'] = Md5($db_id.$username);
              $query = "INSERT INTO users (oauth_uid,username,email_id,full_name,platform,password,verified,picture,date,ip) VALUES ('$client_id','$username','$client_email','$client_name','$client_plat','$password','1','$client_pic','$date','$ip')"; 
              mysqli_query($con,$query); 
              header("Location: ../oauth.php?new_user");
              exit();
            }

        }
    } elseif ($helper->getError()) {
        // There was an error (user probably rejected the request)
        //echo '<p>Error: ' . $helper->getError();
        //echo '<p>Code: ' . $helper->getErrorCode();
        //echo '<p>Reason: ' . $helper->getErrorReason();
        //echo '<p>Description: ' . $helper->getErrorDescription();
        //exit;
        die("There was an error.");
    }

}
die();
?>