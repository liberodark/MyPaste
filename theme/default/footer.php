<?php
/*
 * @author Balaji
 */
error_reporting(1);
?>
<div id="footer">
<div class="wrapper clearfix" id="colophon">
    	<div class="grid_4"><h3 style="font-size:20px;">Useful Links</h3>
            <dd class="nav-item">
            <a href="/">Home</a>
            </dd>
            
            <dd class="nav-item">
            <a href="/">Create New Paste</a>
            </dd>
            
            <dd class="nav-item">
            <a href="<?php  if ($mod_rewrite == '1') { echo "/page/tos/"; } else { echo "/pages.php?page=tos"; }?>">Terms of Use</a>
            </dd>
            
            <dd class="nav-item">
            <a href="/contact.php">Contact US</a>
            </dd>
            
            <dd class="nav-item">
            <a href="<?php  if ($mod_rewrite == '1') { echo "/page/about/"; } else { echo "/pages.php?page=about"; }?>">About US</a>
            </dd>
        </div>

    <div class="grid_4"><h3 style="font-size:20px;">Our Products</h3>    
            
        <dd class="nav-item">
        <a href="https://codecanyon.net/item/atoz-seo-tools-search-engine-optimization-tools/12170678">A to Z SEO Tools </a>
        </dd>
        
        <dd class="nav-item">
        <a href="http://codecanyon.net/item/pptp-l2tp-vpn-client/8167857">PPTP &amp; L2TP VPN Client</a>
        </dd>
        
        <dd class="nav-item">
        <a href="http://prothemes.biz/index.php?route=product/product&amp;path=65&amp;product_id=59">Pro IP locator Script</a>
        </dd>
        
        <dd class="nav-item">
        <a href="http://codecanyon.net/item/isdownornot-website-down-or-not/7472143">IsDownOrNot Script</a>
        </dd>
        
        <dd class="nav-item">
        <a href="https://codecanyon.net/item/custom-openvpn-gui-pro-edition/9904287">Custom OpenVPN GUI</a>
        </dd>
        
    </div>
		
    <div class="grid_4"><h3 style="font-size:20px;">Stay in Touch</h3><br />


  <ul id='services'>
    <li>
    <a href="<?php echo $face; ?>"> <div class='entypo-facebook'></div></a>
    </li>
    <li>
    <a href="<?php echo $twit; ?>"> <div class='entypo-twitter'></div></a>
    </li>
    <li>
    <a href="<?php echo $gplus; ?>"> <div class='entypo-gplus'></div></a>
    </li>
  </ul>
       
        <br />
    </div>
</div>
<br />
<!--copy_right-->
<div id="copy_right" class="wrapper clearfix" style="color:#666; font-size:14px;">Copyright &copy; 2017 
<a href="http://prothemes.biz" target="_blank" title="ProThemes.Biz" style="color:#777;">
ProThemes.Biz</a>. All rights reserved.
</div>
<!--end copy_right-->
                <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '<?php echo $ga; ?>', 'auto');
  ga('send', 'pageview');

</script>
</div>