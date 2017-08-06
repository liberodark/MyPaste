<?php
/*
 * @author Balaji
 */
error_reporting(1);
?>
<style>
.table_archive td {
    border-bottom: 1px solid #EEEEEE;
    padding: 10px 8px;
    vertical-align: top;
}

.table_archive th {
    border-bottom: 1px solid #CCCCCC;
    padding: 4px 6px;
    text-transform: uppercase;
}
</style>
<div id="main" class="container" role="main">
<div class="content">                
<div class="content_1"><br />
<h3 style="font-weight: bold;"><?php echo $page_title; ?> </h3><br />
<br />
<br />
<?php 
if (isset($stats))
echo $page_content; 
else
echo '<div class="alert alert-error">
<strong>Alert!</strong> '.$lang['56'].'
</div>'; 
?>
</div>
<div class="content_2">
<?php require_once('theme/'.$default_theme.'/sidebar.php'); ?>
</div>
<?php echo $ads_2; ?> 
</div></div>