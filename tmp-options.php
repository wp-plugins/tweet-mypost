<div class="wrap">
	<div id="icon-options-general" class="icon32"><br /></div>
	<h2><?php echo __('Tweet myPost Settings', 'tweet_mypost');?></h2>
	<?php
	if(isset($_POST['submit'])){
		$options['consumerkey']		= trim($_POST['set_ckey']);
		$options['consumersecret']	= trim($_POST['set_csec']);
		$options['token']			= trim($_POST['set_token']);
		$options['secret']			= trim($_POST['set_secret']);
		$options['format']			= trim($_POST['set_formatpost']);
		if(trim($_POST['type_short']) == 'migre.me'){
			$options['shorturl']	= array('migre.me' => 'http://migre.me/api.txt?url=%link%');
		}
		if(trim($_POST['type_short']) == 'tinyurl'){
			$options['shorturl']    = array('tinyurl' => 'http://tinyurl.com/api-create.php?url=%link%');
		}
		if(trim($_POST['type_short']) == 'md2.in'){
			$options['shorturl']    = array('md2.in' => 'http://md2.in/api.php?url=%link%');
		}
		if(trim($_POST['type_short']) == 'goo.gl'){
			$options['shorturl']    = array('goo.gl' => 'http://md2.in/googl.php?url=%link%');
		}
		if(trim($_POST['type_short']) == 'vai.la'){
			$options['shorturl']    = array('vai.la' => 'http://vai.la/link/api/?url=%link%');
		}
		if(trim($_POST['type_short']) == 'is.gd'){
			$options['shorturl']    = array('is.dg' => 'http://is.gd/api.php?longurl=%link%');
		}
		if(trim($_POST['type_short']) == 'saf.li'){
			$options['shorturl']    = array('saf.li' => 'http://saf.li/create?ws=1&url=%link%');
		}
		if(trim($_POST['type_short']) == 'u.nu'){
			$options['shorturl']    = array('u.nu' => 'http://u.nu/unu-api-simple?url=%link%');
		}
		if(trim($_POST['type_short']) == 'bit.ly'){
			$options['shorturl']    = array('bit.ly' => 'http://api.bit.ly/v3/shorten?login='.trim($_POST['login']).'&apiKey='.trim($_POST['apikey']).'&longUrl=%link%&format=txt',
											'login' => trim($_POST['login']),
											'apiKey' => trim($_POST['apikey']));
		}
		if(trim($_POST['type_short']) == 'j.mp'){
			$options['shorturl']    = array('j.mp' => 'http://api.j.mp/v3/shorten?login='.trim($_POST['login']).'&apiKey='.trim($_POST['apikey']).'&longUrl=%link%&format=txt',
											'login' => trim($_POST['login']),
											'apiKey' => trim($_POST['apikey']));
		}
		if(trim($_POST['type_short']) == 'custom'){
			$options['shorturl']    = array('custom' => trim($_POST['custom_short']));
		}
		update_option('tweetmp_options', $options);
	?>
    <div class="updated">
    	<p><strong><?php echo __('Settings updated.', 'tweet_mypost');?></strong></p>
    </div>
    <?php
	}
	$options	= get_option('tweetmp_options');
	if(!is_array($options)){
		if(get_option('tweetmp_consumerkey')){
			$options['consumerkey'] = get_option('tweetmp_consumerkey');
			$options['consumersecret'] = get_option('tweetmp_consumersecret');
			$options['token'] = get_option('tweetmp_token');
			$options['secret'] = get_option('tweetmp_secret');
			$options['format'] = get_option('tweetmp_formatpost');
			$options['shorturl'] = array(get_option('tweetmp_typeshort') => get_option('tweetmp_shorturl'));
		}
		else{
			$options['consumerkey'] = '';
			$options['consumersecret'] = '';
			$options['token'] = '';
			$options['secret'] = '';
			$options['format'] = '%title% %link%';
			$options['shorturl'] = array('bit.ly' => 'http://api.bit.ly/v3/shorten?login=tweetmp&apiKey=R_9575276ff0a6d580077227bed2c4f11e&longUrl=%link%&format=txt',
													'login' => 'tweetmp',
													'apiKey' => 'R_9575276ff0a6d580077227bed2c4f11e');
		}
	}
	$shorturl	= array_keys($options['shorturl']);
	$shortapi	= array_values($options['shorturl']);
	if((!empty($shortapi[1]))AND(!empty($shortapi[2]))){
		$login	= $shortapi[1];
		$apikey	= $shortapi[2];
	}
	else{
		$login	= 'tweetmp';
		$apikey	= 'R_9575276ff0a6d580077227bed2c4f11e';
	}
	?>
	<table border="0" cellpadding="5" cellspacing="10" width="100%">
		<tr>
			<td valign="top" width="50%">
				<div id="poststuff">
					<div class="postbox">
						<h3 class="hndle"><?php echo __('OAuth Twitter Settings', 'tweet_mypost');?></h3>
						<form method="post">
						<div class="inside">
							<p>Consumer Key: <br/>
							<input type="text" name="set_ckey" size="60" value="<?php echo $options['consumerkey']; ?>" /></p>
							<p>Consumer Secret: <br/>
							<input type="text" name="set_csec" size="60" value="<?php echo $options['consumersecret']; ?>" /></p>
							<p>Access Token: <br/>
							<input type="text" name="set_token" size="60" value="<?php echo $options['token']; ?>" /></p>
							<p>Access Token Secret: <br/>
							<input type="text" name="set_secret" size="60" value="<?php echo $options['secret']; ?>" /></p>
						</div>
					</div>
				</div>
			<div id="poststuff">
				<div class="postbox">
					<h3 class="hndle"><?php echo __('Format tweet', 'tweet_mypost');?></h3>
					<div class="inside">
						<p>
						<input type="text" name="set_formatpost" size="60" value="<?php echo $options['format']; ?>"/><br/>
						<small>
						%title% - <?php echo __('Post title', 'tweet_mypost');?>
						<br/>
						%link% - <?php echo __('Post URL', 'tweet_mypost');?>
						<br/>
						%cat% - <?php echo __('Post category', 'tweet_mypost');?>
						</small>
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
								<td><label><input name="type_short" type="radio" value="tinyurl" onclick="document.getElementById('customapi').style.display='none'; document.getElementById('bitly').style.display='none';" <?php if($shorturl[0] == 'tinyurl'){echo'checked';}?>/> tinyurl</label></td>
								<td><label><input name="type_short" type="radio" value="goo.gl" onclick="document.getElementById('customapi').style.display='none'; document.getElementById('bitly').style.display='none';" <?php if($shorturl[0] == 'goo.gl'){echo'checked';}?>/> goo.gl</label></td>
							</tr>
							<tr>
								<td><label><input name="type_short" type="radio" value="saf.li" onclick="document.getElementById('customapi').style.display='none'; document.getElementById('bitly').style.display='none';" <?php if($shorturl[0] == 'saf.li'){echo'checked';}?>/> saf.li</label></td>
								<td><label><input name="type_short" type="radio" value="md2.in" onclick="document.getElementById('customapi').style.display='none'; document.getElementById('bitly').style.display='none';" <?php if($shorturl[0] == 'md2.in'){echo'checked';}?>/> md2.in</label></td>
							</tr>
							<tr>
								<td><label><input name="type_short" type="radio" value="is.gd" onclick="document.getElementById('customapi').style.display='none'; document.getElementById('bitly').style.display='none';" <?php if($shorturl[0] == 'is.gd'){echo'checked';}?>/> is.gd</label></td>
								<td><label><input name="type_short" type="radio" value="migre.me" onclick="document.getElementById('customapi').style.display='none'; document.getElementById('bitly').style.display='none';" <?php if($shorturl[0] == 'migre.me'){echo'checked';}?>/> migre.me</label></td>
							</tr>
							<tr>
								<td><label><input name="type_short" type="radio" value="vai.la" onclick="document.getElementById('customapi').style.display='none'; document.getElementById('bitly').style.display='none';" <?php if($shorturl[0] == 'vai.la'){echo'checked';}?>/> vai.la</label></td>
								<td><label><input name="type_short" type="radio" value="u.nu" onclick="document.getElementById('customapi').style.display='none'; document.getElementById('bitly').style.display='none';" <?php if($shorturl[0] == 'u.nu'){echo'checked';}?>/> u.nu</label></td>
							</tr>
							<tr>
								<td><label><input name="type_short" type="radio" value="bit.ly" onclick="document.getElementById('customapi').style.display='none'; document.getElementById('bitly').style.display='block';" <?php if($shorturl[0] == 'bit.ly'){echo'checked';}?>/> bit.ly</label></td>
								<td><label><input name="type_short" type="radio" value="j.mp" onclick="document.getElementById('customapi').style.display='none'; document.getElementById('bitly').style.display='block';" <?php if($shorturl[0] == 'j.mp'){echo'checked';}?>/> j.mp</label></td>
							</tr>
							<tr>
								<td><label><input name="type_short" type="radio" value="custom" onclick="document.getElementById('bitly').style.display='none'; document.getElementById('customapi').style.display='block';" <?php if($shorturl[0] == 'custom'){echo'checked';}?>/> <?php echo __('Custom', 'tweet_mypost');?></label></td>
							</tr>
						</table>
						<table class="form-table">
							<tr>
								<td><div id="customapi" style="display:none">
										<label style="display:inline-block;width:35px;"><strong>API </strong></label> <input name="custom_short" size="45" type="text" value="<?php echo $shortapi[0];?>" />
										<p><small>%link% - <?php echo __('Post URL', 'tweet_mypost');?></small></p>
									</div>
									<div id="bitly" style="display:none">
										<label style="display:inline-block;width:125px;"><strong>Login bit.ly/j.mp</strong></label> <input name="login" size="25" type="text" value="<?php echo($login);?>" /><br />
										<label style="display:inline-block;width:125px;"><strong>apiKey bit.ly/j.mp</strong></label> <input name="apikey" size="25" type="text" value="<?php echo($apikey);?>" />
									</div>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div align="right">
				<input type="submit" name="submit" class="button-primary" value="<?php echo __('Update settings', 'tweet_mypost');?>" />
				</form>
			</div>
			</td>
			<td valign="top" width="50%">
				<div id="poststuff">
					<div class="postbox">
						<h3 class="hndle"><?php echo __('Support', 'tweet_mypost');?></h3>
						<div class="inside">
							<p>
							<?php echo __('Already have access token?', 'tweet_mypost');?>
							<br/>
							<?php echo __('Register your <a href="http://dev.twitter.com/apps/new" target="_blank">application on Twitter</a>.', 'tweet_mypost');?>
							</p>
							<p>
							<small>*<em>
							<?php echo __('Step by step: <a href="http://www.reitor.org/wp-plugins/tweet-mypost/" target="_blank">www.reitor.org/wp-plugins/tweet-mypost/</a>', 'tweet_mypost');?> (pt_BR)
							</em></small>
							</p>
						</div>
					</div>
				</div>
				<div id="poststuff">
					<div class="postbox">
						<h3 class="hndle"><?php echo __('How to support me?', 'tweet_mypost');?></h3>
						<div class="inside">
							<p>
							<strong><?php echo __('Help me to improve the plugin.', 'tweet_mypost');?></strong>
							<br/>
							<?php echo __('Send me bug reports, bugfixes, code modifications or your ideas.', 'tweet_mypost');?>
							</p>
							<p>
							<strong><?php echo __('Make a translation of the plugin.', 'tweet_mypost');?></strong>
							<br/>
							<?php echo __('The give other users more comfort help me to translate it to all languages.', 'tweet_mypost');?>
							</p>
							<p>
							<strong><?php echo __('Make A Donation', 'tweet_mypost');?></strong>
							<br/>
							<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
								<input type="hidden" name="cmd" value="_s-xclick">
								<input type="hidden" name="hosted_button_id" value="BAUHVBXZACWCQ">
								<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
								<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
							</form>
							</p>
							<p>
							<strong><?php echo __('Share', 'tweet_mypost');?></strong>
							<br/>
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