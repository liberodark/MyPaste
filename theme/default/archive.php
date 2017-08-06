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
<h3 style="font-weight: bold;"><?php echo $lang['28']; ?><br />
<?php echo $lang['29']; ?></h3>
<br />

<br />
<table class="table_archive">
<thead>
<tr>
<td><?php echo $lang['30']; ?></td>
<td><?php echo $lang['31']; ?></td>
<td ><?php echo $lang['32']; ?></td></tr>
</thead>
<tbody>
<?php 
            
   $res = getRecent($con,100);
   while($row = mysqli_fetch_array($res)) {
    $title =  Trim($row['title']);
    $p_id =  Trim($row['id']);
    $p_code =  Trim($row['code']);
    $p_date = Trim($row['date']);
    $p_time = Trim($row['now_time']);
    $nowtime = time();
    $oldtime = $p_time;
    $p_time = conTime($nowtime-$oldtime);
    $title = truncate($title, 5, 30);
    if ($mod_rewrite == '1')
    {
    echo ' <tr> 
    <td><a href="/'.$p_id.'/" target="_self" title="'.$title.'">'.ucfirst($title).'</a></td>    
    <td>'.$p_time.'</td>
    <td>'.strtoupper($p_code).'</td></tr>';  
    }
    else
    {
    echo ' <tr> 
    <td><a href="/paste.php?id='.$p_id.'" target="_self" title="'.$title.'">'.ucfirst($title).'</a></td>    
    <td>'.$p_time.'</td>
    <td>'.strtoupper($p_code).'</td></tr>';
    }

}?>
</tbody>
</table>
</div>
<div class="content_2">
<?php require_once('theme/'.$default_theme.'/sidebar.php'); ?>
</div>
<?php echo $ads_2; ?>
</div></div>