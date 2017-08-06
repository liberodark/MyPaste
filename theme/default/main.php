<?php
/*
 * @author Balaji
 */
error_reporting(1);
?>

<div id="main" class="container" role="main">
<div class="content">                
<div class="content_1">
<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
if (isset($success))
{
if ($mod_rewrite == '1') {
    $paste_url = "http://".$_SERVER['SERVER_NAME']."/$success/";
}
else
{
$paste_url = "http://".$_SERVER['SERVER_NAME']."/paste.php?id=$success";
}
?>
<br />
<div class="alert alert-success">
<strong>Alert!</strong> <?php echo $lang['38']; ?>
</div><br />
<strong><?php echo $lang['39']; ?>:</strong> <br /> 
<input readonly="" type="text" id="paste_url" class="form-input" name="paste_url" value="<?php echo $paste_url; ?>"/>
<a class="btn btn-primary" href="<?php echo $paste_url; ?>">View Paste</a> <br /><br /><br />

<label><?php echo $lang['40']; ?></label>
<div class='flyout'>
<ul class='icons'>
<li class="drop-li"><a href="http://www.facebook.com/share.php?u=<?php echo $paste_url; ?>" target="_blank" class="drop-a"><img alt="" src="theme/<?php echo $default_theme; ?>/img/facebook.png"/><b>Share on FB</b><!--[if gte IE 7]><!--></a><!--<![endif]--></li>
<li class="drop-li"><a href="http://twitter.com/share?url=<?php echo $paste_url; ?>" target="_blank" class="drop-a"><img alt="" src="theme/<?php echo $default_theme; ?>/img/twitter.png"/><b>Tweet This</b><!--[if gte IE 7]><!--></a><!--<![endif]--></li>
<li class="drop-li"><a href="http://www.stumbleupon.com/submit?url=<?php echo $paste_url; ?>&title=<?php echo ucfirst($p_title)." | $site_name";?>" target="_blank" class="drop-a"><img alt="" src="theme/<?php echo $default_theme; ?>/img/stumbleupon.png"/><b>Stumble It</b><!--[if gte IE 7]><!--></a><!--<![endif]--></li>
<li class="drop-li"><a href="http://digg.com/submit?phase=2&url=<?php echo $paste_url; ?>&title=<?php echo ucfirst($p_title)." | $site_name";?>" target="_blank" class="drop-a"><img alt="" src="theme/<?php echo $default_theme; ?>/img/digg.png"/><b>Digg This</b><!--[if gte IE 7]><!--></a><!--<![endif]--></li>
<li class="drop-li"><a href="http://delicious.com/post?url1=<?php echo $paste_url; ?>&title=<?php echo ucfirst($p_title)." | $site_name";?>" target="_blank" class="drop-a"><img alt="" src="theme/<?php echo $default_theme; ?>/img/delicious.png"/><b>Delicious</b><!--[if gte IE 7]><!--></a><!--<![endif]--></li>
</ul>
</div>
<?php
}
else
{
echo '<div class="alert alert-error">
<strong>Alert!</strong> '.$error.'
</div>'; 
}
}
else
{
?><br />
<form name="mainForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return valDoc()" method="POST">
<?php echo $lang['41']; ?> <br />
<input type="text" name="title" value="" placeholder="Enter paste title" /> <br />
<?php echo $lang['42']; ?> <br />
<textarea rows="20" cols="70" name="paste_data"></textarea> <br />


<?php echo $lang['43']; ?>				<select name="format">	
<optgroup label="Popular">	
						<?php // Show popular GeSHi formats
							foreach ($geshiformats as $code=>$name)
							{
								if (in_array($code, $popular_formats))
								{
									$sel=($code=="text")?'selected="selected"':' ';
									echo '<option ' . $sel . 'value="' . $code . '">' . $name . '</option>';
								}
							}

							echo '</optgroup><optgroup label="Other Syntax">';

							// Show all GeSHi formats.
							foreach ($geshiformats as $code=>$name)
							{
								if (in_array($code, $popular_formats))
								$sel="";
								echo '<option ' . $sel . 'value="' . $code . '">' . $name . '</option>';
							}
						?></optgroup>
					</select> <br />
<?php echo $lang['44']; ?> 
<select name="paste_expire_date">
 <option value="N" selected="selected">Never</option>
 <option value="self">Self Destory</option>
 <option value="10M">10 Minutes</option>
 <option value="1H">1 Hour</option>
 <option value="1D">1 Day</option>
 <option value="1W">1 Week</option>
 <option value="2W">2 Weeks</option>
 <option value="1M">1 Month</option>
</select> <br />

<?php echo $lang['45']; ?>
					<select name="visibility">
						<option selected value="0">Public
						</option>
						<option  value="1">Unlisted
						</option>
                        <?php if (isset($_SESSION['token'])) {?>
						<option value="2">Private</option>
                        <?php } else { ?>
						<option disabled >Private (Members Only)</option>
                        <?php } ?>
					</select> <br />
                    <?php echo $lang['46']; ?>
<input type="text" name="pass" id="pass" value="" placeholder="(Optional)" /> <br />    
<label><?php echo $lang['47']; ?></label>
<input type="checkbox" name="encrypted"  class="checkbox inline" />  <br />
<?php if ($cap_e == "on") { ?>
<div class="cap_e">
<label><?php echo $lang['48']; ?> </label>   <br />
<?php echo '<img src="' . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA" class="imagever">';   ?>
</div>
<input type="text" name="scode" placeholder="Enter your image verification code..." />
<?php }?>      
<input type="submit" name="submit" id="submit" value="Submit"/><br /> <br />
</form>
<?php } ?>   
</div>
<div class="content_2">
<?php require_once('theme/'.$default_theme.'/sidebar.php'); ?>
</div>
<?php
if (isset($_SESSION['username']))
{?>
<?php echo $ads_2; ?>
<?php } else { ?>
<div style="margin-left: -258px;"> 
<?php echo $ads_2; ?> </div>
<?php } ?>

</div></div>