<?php
/*
Plugin Name: Tweet myPost
Plugin URI: http://reitor.org/wp-plugins/tweet-mypost/
Description: Send to twitter the posts published, using your Twitter App OAuth.
Version: 1.3
Author: Ronis Reitor
Author URI: http://reitor.org/
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
	require_once 'EpiCurl.php';
	require_once 'EpiOAuth.php';
	require_once 'EpiTwitter.php';
	$twitterObj	= new EpiTwitter(get_option('tweetmp_consumerkey'),get_option('tweetmp_consumersecret'),get_option('tweetmp_token'),get_option('tweetmp_secret'));
	$tweet		= $twitterObj->post_statusesUpdate(array('status' => $msg));
	$tweet->responseText;
}
function tmp_shorturl($url){
	$api_url	= str_replace('%link%',$url,get_option('tweetmp_shorturl'));
	$ch		= curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $api_url);
	$s_url		= curl_exec($ch);
	return trim($s_url);
}
function tweetmypost(){
	global $post;
	$post_url		= tmp_shorturl(trim(get_permalink($post->ID)));
	$title			= $post->post_title;
	$search			= array('%title%', '%link%');
	$now			= array($title, $post_url);
	$tweet_mypost	= str_replace($search,$now,get_option('tweetmp_formatpost'));
	if($_POST['tweetm_post'] == 'yes'){
		tmp_tweet($tweet_mypost);
	}
}
function tweetmp_menu(){
	if(function_exists('add_menu_page')){
		add_menu_page(__('Tweet myPost &lsaquo; Settings', 'tweet_mypost'), 'Tweet myPost', 'manage_options', 'tweet_mypost', 'tweetmp_config');
	}
}
function Tweetmp_init(){
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
	add_option('tweetmp_typeshort','migre.me');
	add_option('tweetmp_shorturl','http://migre.me/api.txt?url=%link%');
	add_option('tweetmp_formatpost','%title% - %link%');
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
	if(($post->post_status) != 'publish'){
?>
<label><input id="tweetm_post" type="checkbox" name="tweetm_post" value="yes" checked /> <?php echo __('Send to Twitter', 'tweet_mypost');?></label>
<?php
	}else{?>
<label><input id="tweetm_post" type="checkbox" name="tweetm_post" value="yes" disabled /> <?php echo __('Send to Twitter', 'tweet_mypost');?></label>
<?php
	}
}
add_action('admin_init', 'Tweetmp_init');
add_action('admin_menu', 'tweetmp_menu');
add_action('publish_post', 'tweetmypost');
add_action('admin_print_styles', 'addTweetmpStyle');
register_activation_hook(__FILE__, 'tweetmp_install');
register_deactivation_hook(__FILE__, 'tweetmp_uninstall' );
?>