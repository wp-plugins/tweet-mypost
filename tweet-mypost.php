<?php
/*
Plugin Name: Tweet myPost
Plugin URI: http://reitor.org/wp-plugins/tweet-mypost/
Description: Send to twitter the posts published, using your Twitter App OAuth.
Version: 1.7
Author: Ronis Reitor
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

load_plugin_textdomain(
	'tweet_mypost', 
	false, 
	'tweet-mypost/lang'
);
function tweetmp_config(){
if(!current_user_can('manage_options')) {
	wp_die(__('Unallowed', 'tweet_mypost'));
}
	include('tweetmp_config.php');
}
function tmp_tweet($msg){
	global $post;
	require_once 'EpiCurl.php';
	require_once 'EpiOAuth.php';
	require_once 'EpiTwitter.php';
	$twitterObj	= new EpiTwitter(get_option('tweetmp_consumerkey'),get_option('tweetmp_consumersecret'),get_option('tweetmp_token'),get_option('tweetmp_secret'));
	try{  
		$tweet = $twitterObj->post('/statuses/update.json', array('status' => $msg));
		add_post_meta($post->ID, 'tweetmsgstatus', 'http://twitter.com/'.$tweet->response[user][screen_name].'/status/'.$tweet->response[id]);
	}
	catch(EpiTwitterException $e){  
		$temp = $e->getMessage();
	}
}
function tmp_shorturl($url){
	$api_url	= str_replace('%link%',$url,get_option('tweetmp_shorturl'));
	$ch		= curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $api_url);
	$s_url		= curl_exec($ch);
	return trim($s_url);
}
function tweetmypost($format){
	global $post;
	$post_url	= tmp_shorturl(trim(get_permalink($post->ID)));
	$title		= $post->post_title;
	$category	= wp_get_post_categories($post->ID);
	$category	= get_cat_name($category[0]);
	$search		= array('%title%','%cat%','%link%');
	$now		= array($title,$category,$post_url);
	$tweet_mypost	= str_replace($search,$now,$_POST['tweetmsg_post']);
	add_post_meta($post->ID, 'tweetmsgpost', $tweet_mypost, true) or update_post_meta($post->ID, 'tweetmsgpost', $tweet_mypost);
	tmp_tweet($tweet_mypost);
}
function tweetmp_menu(){
	if(function_exists('add_menu_page')){
		add_menu_page(__('Tweet myPost &lsaquo; Settings', 'tweet_mypost'), 'Tweet myPost', 'manage_options', 'tweet_mypost', 'tweetmp_config');
	}
}
function tweetmp_init(){
	wp_register_style('TweetmpStyle', WP_PLUGIN_URL . '/tweet-mypost/css/style.css');
}
function addTweetmpStyle(){
	wp_enqueue_style('TweetmpStyle');
}
if(get_option('tweetmp_token') == ""){
add_action('admin_notices', 'tweetmp_warning');
}
function tweetmp_warning(){
	echo '<div class="error"><p><a href="'.get_bloginfo('wpurl').'/wp-admin/admin.php?page=tweet_mypost">'.__('Please Configure <strong>Tweet myPost</strong>', 'tweet_mypost').'</a></p></div>';
}
function tweetmp_install(){
	add_option('tweetmp_token');
	add_option('tweetmp_secret');
	add_option('tweetmp_consumerkey');
	add_option('tweetmp_consumersecret');
	add_option('tweetmp_typeshort','tinyurl');
	add_option('tweetmp_shorturl','http://tinyurl.com/api-create.php?url=%link%');
	add_option('tweetmp_formatpost','%title% %link%');
}
function tweetmp_uninstall(){
	delete_option('tweetmp_token');
	delete_option('tweetmp_secret');
	delete_option('tweetmp_consumerkey');
	delete_option('tweetmp_consumersecret');
	delete_option('tweetmp_shorturl');
	delete_option('tweetmp_typeshort');
	delete_option('tweetmp_formatpost');
}
add_action('admin_menu','tmpost_box');
function tmpost_box(){
	if( function_exists('add_meta_box')){
		add_meta_box('tweetmp','Tweet myPost','tweetmp_box','post','side','high');
	}
}
function tweetmp_box(){
	global $post;
?>
<?php if(($post->post_status) != 'publish'){echo "<p><label><input id=\"tweetm_post\" type=\"checkbox\" name=\"tweetm_post\" value=\"yes\"checked />" . __('Send to Twitter', 'tweet_mypost') . "</label></p>";}?>
<p><label><strong>Tweet</strong>
<br />
<input id="tweetmsg_post" size="38" type="text" name="tweetmsg_post" value="<?php if(get_post_meta($post->ID, 'tweetmsgpost', true)){
	echo get_post_meta($post->ID, 'tweetmsgpost', true);
}else{
	echo get_option('tweetmp_formatpost');
} ?>" /></label></p>

<?php if(get_post_meta($post->ID, 'tweetmsgstatus', true)){
	echo "<a href='".get_post_meta($post->ID, 'tweetmsgstatus', true)."' target='_blank'>" . __('tweeted', 'tweet_mypost') . "</a>";
}else{
	if(get_post_meta($post->ID, 'tweetmsgpost', true)){
		echo "<a href='http://twitter.com/home/?status=".get_post_meta($post->ID, 'tweetmsgpost', true)."' target='_blank'>" . __('Error: Send to Twitter', 'tweet_mypost') . "</a>";
	}
} ?>

<?php if(($post->post_status) != 'publish'){?>
<p>
<small>
%title% - <?php echo __('Post title', 'tweet_mypost');?><br/>
%link% - <?php echo __('Post URL', 'tweet_mypost');?><br/>
%cat% - <?php echo __('Post category', 'tweet_mypost');?></small>
</p>
<?php
}}
add_action('admin_init', 'tweetmp_init');
add_action('admin_menu', 'tweetmp_menu');
if($_POST['tweetm_post'] == 'yes'){
	add_action('publish_post', 'tweetmypost');
}
add_action('admin_print_styles', 'addTweetmpStyle');
register_activation_hook(__FILE__, 'tweetmp_install');
register_deactivation_hook(__FILE__, 'tweetmp_uninstall' );
?>