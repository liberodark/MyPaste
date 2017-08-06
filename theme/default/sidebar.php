<div id="tabbed-widget" class="widget">
<?php
if(isset($_SESSION['token']))
{?>
		<div class="widget-container">
			<div class="widget-top">
				<ul class="tabs posts-taps">
					<li class="tabs active"><?php echo $lang['69']; ?></li>
				</ul>
			</div>
			<div class="tabs-wrap">
			
			<ul class="sim_a">
            <?php 
   $user_username = Trim($_SESSION['username']);     
   $res = getUserRecent($con,5,$user_username);
   while($row = mysqli_fetch_array($res)) {
    $title =  Trim($row['title']);
    $p_id =  Trim($row['id']);
    $p_date = Trim($row['date']);
    $p_time = Trim($row['now_time']);
    $nowtime = time();
    $oldtime = $p_time;
    $p_time = conTime($nowtime-$oldtime);
    $title = truncate($title, 5, 30);
     if ($mod_rewrite == '1')
     {
            echo '            <li>
    <a href="/'.$p_id.'/" target="_self" title="'.$title.'">'.ucfirst($title).'</a> <br/>
            '.$p_time.'
            </li>';
     }
     else
     {
            echo '            <li>
    <a href="/paste.php?id='.$p_id.'" target="_self" title="'.$title.'">'.ucfirst($title).'</a> <br/>
            '.$p_time.'
            </li>';
     }

    }?>
    <li><br />
    <a class="btn btn-primary"  href="/mypastes.php" target="_self" title="View all pastes"><?php echo $lang['70']; ?></a><br /><br /></li>
            </ul>
		</div>
	</div>
    
    <?php } ?>
		<div class="widget-container">
			<div class="widget-top">
				<ul class="tabs posts-taps">
					<li class="tabs active"><?php echo $lang['71']; ?></li>
				</ul>
			</div>
			<div class="tabs-wrap">
			
			<ul class="sim_a">
            <?php 
            
   $res = getRecent($con,5);
   while($row = mysqli_fetch_array($res)) {
    $title =  Trim($row['title']);
    $p_id =  Trim($row['id']);
    $p_date = Trim($row['date']);
    $p_time = Trim($row['now_time']);
    $nowtime = time();
    $oldtime = $p_time;
    $p_time = conTime($nowtime-$oldtime);
    $title = truncate($title, 5, 30);
     if ($mod_rewrite == '1')
     {
            echo '            <li>
    <a href="/'.$p_id.'/" target="_self" title="'.$title.'">'.ucfirst($title).'</a> <br/>
            '.$p_time.'
            </li>';
     }
     else
     {
            echo '            <li>
    <a href="/paste.php?id='.$p_id.'" target="_self" title="'.$title.'">'.ucfirst($title).'</a> <br/>
            '.$p_time.'
            </li>';
     }
     }
     ?>
            </ul>
		</div>
	</div>

</div>
<?php echo $ads_1; ?>
