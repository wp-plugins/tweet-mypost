<?php
/*
Plugin Name: Tweet myPost
Plugin URI: http://reitor.org/wp-plugins/tweet-mypost/
Description: Send to twitter the posts published, using your Twitter App OAuth. Supports scheduling posts.
Version: 1.9.1
Author: Ronis Reitor, Bruno Braga
Author URI: http://reitor.org/
License: GPLv3
*/

/*
This program is free software; you can redistribute it and/or modify 
it under the terms of the GNU General Public License as published by 
the Free Software Foundation; version 2 of the License.

This program is distributed in the hope that it will be useful, 
but WITHOUT ANY WARRANTY; without even the implied warranty of 
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
GNU General Public License for more details. 

You should have received a copy of the GNU General Public License 
along with this program; if not, write to the Free Software 
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA 
*/

load_plugin_textdomain('tweet_mypost',false,'tweet-mypost/lang');
$options = get_option('tweetmp_options');
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
	add_action('admin_notices', 'tweetmp_warning');
}
function tweetmp_config(){
if(!current_user_can('manage_options')) {
	wp_die(__('Unallowed', 'tweet_mypost'));
}
	include('tmp-options.php');
}
function tmp_tweet($msg,$postID){
	global $options;
	require_once 'OAuth.php';
	require_once 'twitteroauth.php';
	$twitterObj	= new TwitterOAuth($options['consumerkey'],$options['consumersecret'],$options['token'],$options['secret']);
	$tweet		= $twitterObj->post('statuses/update', array('status' => $msg));
	if(!isset($tweet->error)){
		add_post_meta($postID, 'tweetmsgstatus', 'http://twitter.com/'.$tweet->user->screen_name.'/status/'.$tweet->id);
		add_post_meta($postID, 'tweetmsg', $tweet->text);
	}
	else{
		add_post_meta($postID, 'tweetmsg', $tweet->error);
	}
}
function tmp_shorturl($url){
	global $options;
	$shortapi	= array_values($options['shorturl']);
	$api_url	= str_replace('%link%',$url,$shortapi[0]);
	$ch			= curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $api_url);
	$s_url		= curl_exec($ch);
	curl_close($ch);
	return trim($s_url);
}
function tweetmypost($postID){
	global $options;
	$post		= get_post($postID);
	$title		= $post->post_title;
	$post_url	= tmp_shorturl(get_permalink($post->ID));
	$category	= wp_get_post_categories($post->ID);
	$category	= get_cat_name($category[0]);
	$now		= array($title,$category,$post_url);
	$search		= array('%title%','%cat%','%link%');
	$strSearch	= isset($_POST['tweetmsg_post'])?$_POST['tweetmsg_post']:$options['format'];
	$tweet		= str_replace($search,$now,$strSearch);
	tmp_tweet($tweet,$postID);
}
function tweetmp_menu(){
	if(function_exists('add_menu_page')){
		add_menu_page(__('Tweet myPost &lsaquo; Settings', 'tweet_mypost'), 'Tweet myPost', 'manage_options', 'tweet-mypost', 'tweetmp_config');
	}
}
function tweetmp_init(){
	wp_register_style('tweetmp_style', WP_PLUGIN_URL . '/tweet-mypost/css/style.css');
}
function tweetmp_style(){
	wp_enqueue_style('tweetmp_style');
}
function tweetmp_warning(){
	echo '<div class="error"><p><a href="'.get_bloginfo('wpurl').'/wp-admin/admin.php?page=tweet-mypost">'.__('Please Configure <strong>Tweet myPost</strong>', 'tweet_mypost').'</a></p></div>';
}
add_action('admin_menu','tweetmp_add_box');
function tweetmp_add_box(){
	if(function_exists('add_meta_box')){
		add_meta_box('tweetmp','Tweet myPost','tweetmp_box','post','side','high');
	}
}
function tweetmp_box(){
	global $post, $options;
?>
<?php
if(($post->post_status) != 'publish'){
?>
<p>
	<label>
		<input id="tweetm_post" type="checkbox" name="tweetm_post" value="1" checked />
		<?php echo __('Send to Twitter', 'tweet_mypost');?>
	</label>
</p>
<p>
	<small>
		%title% - <?php echo __('Post title', 'tweet_mypost');?>
		<br />
		%link% - <?php echo __('Post URL', 'tweet_mypost');?>
		<br />
		%cat% - <?php echo __('Post category', 'tweet_mypost');?>
	</small>
</p>
<?php
}
?>
<p>
	<label>
		<strong>Tweet</strong>
		<br />
		<input id="tweetmsg_post" size="38" type="text" name="tweetmsg_post" value="<?php
			if(get_post_meta($post->ID, 'tweetmsg', true)){
				echo get_post_meta($post->ID, 'tweetmsg', true);
			}
			else{
				echo $options['format'];
			}
		?>" />
	</label>
</p>
<?php
	if(get_post_meta($post->ID, 'tweetmsgstatus', true)){
		echo "<a href='".get_post_meta($post->ID, 'tweetmsgstatus', true)."' target='_blank'>" . __('tweeted', 'tweet_mypost') . "</a>";
	}
	else{
		if(get_post_meta($post->ID, 'tweetmsg', true)){
			echo __('error sending tweet', 'tweet_mypost');
		}
	}
}
add_action('admin_init', 'tweetmp_init');
add_action('admin_menu', 'tweetmp_menu');
add_action('admin_print_styles', 'tweetmp_style');
if($_POST['tweetm_post'] == '1'){
	add_action('publish_post', 'tweetmypost');
}
add_action('publish_future_post', 'tweetmypost',10,1);
?>