<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>
<h2><?php echo __('Tweet myPost Settings', 'tweet_mypost');?></h2>
<?php
if (isset($_POST['submit'])) {
	update_option('tweetmp_consumerkey', trim($_POST['set_ckey']));
	update_option('tweetmp_consumersecret', trim($_POST['set_csec']));
	update_option('tweetmp_token', trim($_POST['set_token']));
	update_option('tweetmp_secret', trim($_POST['set_secret']));
	update_option('tweetmp_typeshort', trim($_POST['type_short']));
	update_option('tweetmp_formatpost', $_POST['set_formatpost']);
	if($_POST['type_short'] == 'migre.me'){
		update_option('tweetmp_shorturl', 'http://migre.me/api.txt?url=%link%');
	}
	if($_POST['type_short'] == 'vai.la'){
		update_option('tweetmp_shorturl', 'http://vai.la/link/api/?url=%link%');
	}
	if($_POST['type_short'] == 'is.gd'){
		update_option('tweetmp_shorturl', 'http://is.gd/api.php?longurl=%link%');
	}
	if($_POST['type_short'] == 'u.nu'){
		update_option('tweetmp_shorturl', 'http://u.nu/unu-api-simple?url=%link%');
	}
	if($_POST['type_short'] == 'custom'){
		update_option('tweetmp_shorturl', trim($_POST['custom_short']));
	}
?>
    <div class="updated">
    	<p><strong><?php echo __('Settings updated.', 'tweet_mypost');?></strong></p>
    </div>
    <?php
}
?>
<form method="post">
<table border="0" cellpadding="5" cellspacing="10" width="100%">
<tr>
<td valign="top" width="50%">
<div id="poststuff">
<div class="postbox">
<h3 class="hndle"><?php echo __('OAuth Twitter Settings', 'tweet_mypost');?></h3>
<div class="inside">
<p>Consumer Key: <br>
<input type="text" name="set_ckey" size="60" value="<?php echo get_option('tweetmp_consumerkey'); ?>" /></p>
<p>Consumer Secret: <br>
<input type="text" name="set_csec" size="60" value="<?php echo get_option('tweetmp_consumersecret'); ?>" /></p>
<p>Access Token: <br>
<input type="text" name="set_token" size="60" value="<?php echo get_option('tweetmp_token'); ?>" /></p>
<p>Access Token Secret: <br>
<input type="text" name="set_secret" size="60" value="<?php echo get_option('tweetmp_secret'); ?>" /></p>
</div>
</div>
</div>
<div id="poststuff">
<div class="postbox">
<h3 class="hndle"><?php echo __('Format tweet', 'tweet_mypost');?></h3>
<div class="inside">
<p>
<input type="text" name="set_formatpost" size="60" value="<?php echo get_option('tweetmp_formatpost'); ?>"/><br/>
<small>%title% - <?php echo __('Post title', 'tweet_mypost');?><br/>
%link% - <?php echo __('Post URL', 'tweet_mypost');?></small>
</p>
</div>
</div>
</div>
<div id="poststuff">
<div class="postbox">
<h3 class="hndle"><?php echo __('Shorten', 'tweet_mypost');?></h3>
<div class="inside">
<table class="form-table">
	<tr>
		<td width="35%"><label><input name="type_short" type="radio" value="is.gd" <?php if(get_option('tweetmp_typeshort') == 'is.gd'){echo'checked';}?>/> is.gd</label></td>
		<td width="65%"><label><input name="type_short" type="radio" value="migre.me" <?php if(get_option('tweetmp_typeshort') == 'migre.me'){echo'checked';}?>/> migre.me</label></td>
	</tr>
	<tr>
		<td><label><input name="type_short" type="radio" value="vai.la" <?php if(get_option('tweetmp_typeshort') == 'vai.la'){echo'checked';}?>/> vai.la</label></td>
		<td><label><input name="type_short" type="radio" value="u.nu" <?php if(get_option('tweetmp_typeshort') == 'u.nu'){echo'checked';}?>/> u.nu</label></td>
	</tr>
	<tr>
		<td><label><input name="type_short" type="radio" value="custom" <?php if(get_option('tweetmp_typeshort') == 'custom'){echo'checked';}?>/> <?php echo __('Custom', 'tweet_mypost');?></label></td>
		<td><input name="custom_short" size="35" type="text" value="<?php echo get_option('tweetmp_shorturl');?>" /></td>
	</tr>
</table><p>
<small>%link% - <?php echo __('Post URL', 'tweet_mypost');?></small></p>
</div>
</div>
</div>
</td>
<div align="right">
<input type="submit" name="submit" class="button-primary" value="<?php echo __('Update settings', 'tweet_mypost');?>" />
</form>
</div>
<td valign="top" width="50%">
<div id="poststuff">
<div class="postbox">
<h3 class="hndle"><?php echo __('Support', 'tweet_mypost');?></h3>
<div class="inside">
<p><?php echo __('Already have access token?', 'tweet_mypost');?><br/>
<?php echo __('Register your <a href="http://dev.twitter.com/apps/new" target="_blank">application on Twitter</a>.', 'tweet_mypost');?></p>
<p>
<small>*<em><?php echo __('Step by step: <a href="http://www.reitor.org/wp-plugins/tweet-mypost/" target="_blank">www.reitor.org/wp-plugins/tweet-mypost/</a>', 'tweet_mypost');?></em></small>
</p>
</div>
</div>
</div>
<div id="poststuff">
<div class="postbox">
<h3 class="hndle"><?php echo __('How to support me?', 'tweet_mypost');?></h3>
<div class="inside">
<p><strong><?php echo __('Help me to improve the plugin.', 'tweet_mypost');?></strong><br/>
<?php echo __('Send me bug reports, bugfixes, code modifications or your ideas.', 'tweet_mypost');?></p>
<p><strong><?php echo __('Make a translation of the plugin.', 'tweet_mypost');?></strong><br/>
<?php echo __('The give other users more comfort help me to translate it to all languages.', 'tweet_mypost');?></p>
<p><strong><?php echo __('Make A Donation', 'tweet_mypost');?></strong><br/>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="BAUHVBXZACWCQ">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form></p>
<p><strong><?php echo __('Share', 'tweet_mypost');?></strong><br/>
<a href="http://twitter.com/share" class="twitter-share-button" data-url="http://wordpress.org/extend/plugins/tweet-mypost/" data-text="#wp #plugin I indicate Tweet myPost..." data-count="horizontal" data-via="Reitor">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>

<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwordpress.org%2Fextend%2Fplugins%2Ftweet-mypost%2F&amp;layout=button_count&amp;show_faces=false&amp;width=120&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:120px; height:21px;" allowTransparency="true"></iframe>
</p>
</div>
</div>
</div>
</td>
</tr>
</table>
</div>