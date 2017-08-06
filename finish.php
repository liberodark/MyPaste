<?php
/*
 * @author Balaji
 */
error_reporting(1);
require_once("config.php");

$admin_user = htmlentities(Trim($_POST['admin_user']));
$admin_pass = Md5(htmlentities(Trim($_POST['admin_pass'])));

$con = mysqli_connect($mysql_host,$mysql_user,$mysql_pass,$mysql_database);

  if (mysqli_connect_errno())
  {
  echo "Failed to connect:". mysqli_connect_error()."<br>";
  }

$sql = "CREATE TABLE admin 
(
id INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(id),
user VARCHAR(250),
pass VARCHAR(250)
)";
    // Execute query
    if (mysqli_query($con,$sql)) {
    echo "Admin Table created successfully <br>";
    } else {
    echo "Error creating table: " . mysqli_error($con)."<br>";
     }
     
    $query = "INSERT INTO admin (user,pass) VALUES ('$admin_user','$admin_pass')"; 
    mysqli_query($con,$query);
    
$sql = "CREATE TABLE admin_history 
(
id INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(id),
last_date VARCHAR(255),
ip VARCHAR(255)
)";
    // Execute query
    if (mysqli_query($con,$sql)) {
    echo "Admin History Table created successfully <br>";
    } else {
    echo "Error creating table: " . mysqli_error($con)."<br>";
     }
   $query = "INSERT INTO admin_history (last_date,ip) VALUES ('14th June 2016','23.54.2.43')"; 
   mysqli_query($con,$query);
   $query = "INSERT INTO admin_history (last_date,ip) VALUES ('14th June 2016','26.32.34.33')"; 
   mysqli_query($con,$query);
   $query = "INSERT INTO admin_history (last_date,ip) VALUES ('15th June 2016','31.7.42.03')"; 
   mysqli_query($con,$query);
   
   
   $sql = "CREATE TABLE page_view 
(
id INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(id),
date VARCHAR(255),
tpage VARCHAR(255),
tvisit VARCHAR(255)
)";
    // Execute query
    if (mysqli_query($con,$sql)) {
    echo "Page view Table created successfully <br>";
    } else {
    echo "Error creating table: " . mysqli_error($con)."<br>";
     }

   $sql = "CREATE TABLE ads 
(
id INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(id),
text_ads text,
ads_1 text,
ads_2 text
)";
    // Execute query
    if (mysqli_query($con,$sql)) {
    echo "Ads Table created successfully <br>";
    } else {
    echo "Error creating table: " . mysqli_error($con)."<br>";
     }
     
     $query = "INSERT INTO ads (text_ads,ads_1,ads_2) VALUES ('<br />
Try Pro IP locator Script Today! CLICK HERE <br /><br />

Get 20,000 Unique Traffic for $5 [Limited Time Offer] - Buy Now! CLICK HERE<br /><br />

Custom OpenVPN GUI - Get Now for $15 ! CLICK HERE<br />','<br />
<div style=\"margin-left: -13px;\" >
<img class=\"imageres\" src=\"/theme/default/img/ad250.gif\">
</div>','<br /><br /><center>
<div >
<img class=\"imageres\" src=\"/theme/default/img/ad700.png\">
</div></center>')"; 
     mysqli_query($con,$query);
     
     
   $sql = "CREATE TABLE site_info 
(
id INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(id),
title VARCHAR(255),
des mediumtext,
keyword mediumtext,
site_name VARCHAR(255),
email VARCHAR(255),
twit VARCHAR(4000),
face VARCHAR(4000),
gplus VARCHAR(4000),
ga VARCHAR(255)
)";
    // Execute query
    if (mysqli_query($con,$sql)) {
    echo "Site Info Table created successfully <br>";
    } else {
    echo "Error creating table: " . mysqli_error($con)."<br>";
     }
     
     $query = "INSERT INTO site_info (title,des,keyword,site_name,email,twit,face,gplus,ga) VALUES ('MyPasteBox - Powerful paste tool','MyPasteBox is a advanced text storage tool where you can store text, sensitive data and source code for a set period of time.','mypastebox,pastebin,text,paste,online paste','MyPasteBox','admin@prothemes.biz','https://twitter.com/','https://www.facebook.com/','https://plus.google.com/','UA-')"; 
     mysqli_query($con,$query);


   $sql = "CREATE TABLE interface 
(
id INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(id),
theme text,
lang text
)";
    // Execute query
    if (mysqli_query($con,$sql)) {
    echo "Interface Table created successfully <br>";
    } else {
    echo "Error creating table: " . mysqli_error($con)."<br>";
     }
     
     $query = "INSERT INTO interface (theme,lang) VALUES ('default','en.php')"; 
     mysqli_query($con,$query);
     
   $sql = "CREATE TABLE ban_user 
(
id INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(id),
ip VARCHAR(255),
last_date VARCHAR(255)
)";
    // Execute query
    if (mysqli_query($con,$sql)) {
    echo "Ban User Table created successfully <br>";
    } else {
    echo "Error creating table: " . mysqli_error($con)."<br>";
     }
     
     $query = "INSERT INTO ban_user (id,ip,last_date) VALUES ('1','2.2.2.2','17th June 2016')"; 
     mysqli_query($con,$query);
     
      $sql = "CREATE TABLE users 
(
id INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(id),
oauth_uid text,
username text,
email_id text,
full_name text,
platform text,
password text,
verified text,
picture text,
date text,
ip text
)";
    // Execute query
    if (mysqli_query($con,$sql)) {
    echo "Users Table created successfully <br>";
    } else {
    echo "Error creating table: " . mysqli_error($con)."<br>";
     }
     
     
     
      $sql = "CREATE TABLE mail 
(
id INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(id),
smtp_host text,
smtp_username text,
smtp_password text,
smtp_port text,
protocol text,
auth text,
socket text
)";
    // Execute query
    if (mysqli_query($con,$sql)) {
    echo "Mail Table created successfully <br>";
    } else {
    echo "Error creating table: " . mysqli_error($con)."<br>";
     }
     
     
     $query = "INSERT INTO mail (smtp_host,smtp_username,smtp_password,smtp_port,protocol,auth,socket) VALUES ('','','','','1','true','ssl')"; 
     mysqli_query($con,$query);
          
     
           $sql = "CREATE TABLE pages 
(
id INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(id),
last_date VARCHAR(255),
page_name VARCHAR(255),
page_title mediumtext,
page_content text
)";
    // Execute query
    if (mysqli_query($con,$sql)) {
    echo "Pages Table created successfully <br>";
    } else {
    echo "Error creating table: " . mysqli_error($con)."<br>";
     }
     
     $query = "INSERT INTO pages (id,last_date,page_name,page_title,page_content) VALUES ('1','17th June 2016','about','About US','<p><strong>Nothing to say</strong></p><br><br><br><br><br><br><br><br><br><br>')"; 
     mysqli_query($con,$query);
    
               
   $sql = "CREATE TABLE pastes 
(
id INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(id),
title text,
content text,
visible text,
code text,
expiry text,
password text,
encrypt text,
member text,
date text,
ip text,
now_time text,
views text,
s_date text
)";
    // Execute query
    if (mysqli_query($con,$sql)) {
    echo "Pastes created successfully <br>";
    } else {
    echo "Error creating table: " . mysqli_error($con)."<br>";
     }
   

  
     $sql = "CREATE TABLE sitemap_options 
(
id INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(id),
priority VARCHAR(255),
changefreq VARCHAR(255)
)";
    // Execute query
    if (mysqli_query($con,$sql)) {
    echo "Sitemap Options Table created successfully <br>";
    } else {
    echo "Error creating table: " . mysqli_error($con)."<br>";
     }
     
     $query = "INSERT INTO sitemap_options (id,priority,changefreq) VALUES ('1','0.9','weekly')"; 
     mysqli_query($con,$query);
              
           $sql = "CREATE TABLE capthca 
(
id INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(id),
cap_e VARCHAR(255),
mode VARCHAR(255),
mul VARCHAR(255),
allowed text,
color mediumtext
)";
    // Execute query
    if (mysqli_query($con,$sql)) {
    echo "Capthca Table created successfully <br>";
    } else {
    echo "Error creating table: " . mysqli_error($con)."<br>";
     }
     
     $query = "INSERT INTO capthca (cap_e,mode,mul,allowed,color) VALUES ('off','Normal','off','ABCDEFGHJKLMNPRSTUVWXYZabcdefghjkmnprstuvwxyz234567891','#FFFFFF')"; 
     mysqli_query($con,$query); 
     
  $c_date = date('Y-m-d');
    $data = '<?xml version="1.0" encoding="UTF-8"?>
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>http://'.$_SERVER['SERVER_NAME'].'/</loc>
        <priority>1.0</priority>
        <changefreq>daily</changefreq>
        <lastmod>'.$c_date.'</lastmod>
</url>
</urlset>';
file_put_contents("sitemap.xml",$data);
    echo "Sitemap file created successfully <br> <br>";

  unlink('install.php');
  unlink('process.php');
  unlink('finish.php');
  
  echo 'Installation Complete! <br> <br>';  
?>
  <a href="index.php" class="btn btn-info" >Index Page</a>   <a href="admin/index.php" class="btn btn-info">Admin Panel</a>
