<?php
/*
Plugin Name: Tweet myPost
Plugin URI: http://reitor.org/wp-plugins/tweet-mypost/
Description: Envia para o twitter seu post utilizando sua propria Twitter OAuth.
Version: 1.0
Author: Reitor
Author URI: http://reitor.org/
*/

function tweetmp_config() {
if(!current_user_can('manage_options')) {
	wp_die( __('Você não tem permissão.') );
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
function tmp_isgd($url) {
	$api_isgd	= 'http://is.gd/api.php?longurl='.$url;
	$ch			= curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $api_isgd);
	$s_url		= curl_exec($ch);
	return trim($s_url);
}
function tweetmypost() {
	global $post;
	$post_url		= tmp_isgd(trim(get_permalink($post->ID)));
	$title			= $post->post_title;
	$tweet_mypost	= $title.' - '.$post_url;
	tmp_tweet($tweet_mypost);
}
function tweetmp_menu() {
	if(function_exists('add_menu_page')){
		add_menu_page('Tweet myPost &lsaquo; Configuração', 'Tweet myPost', 'manage_options', 'tweet_mypost', 'tweetmp_config');
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
	echo "<div class=\"error\"><p>Falta <a href=\"".get_bloginfo('wpurl')."/wp-admin/admin.php?page=tweet_mypost\">configurar</a> o <strong>Tweet myPost</strong></p></div>";
}
function tweetmp_install() {
	$tweetmp_Token	 = '';
	$tweetmp_Secret	 = '';
	$tweetmp_Ckey	 = '<Sua consumer key aqui>';
	$tweetmp_Csecret = '<Sua consumer secret aqui>';
	add_option('tweetmp_token', $tweetmp_Token);
	add_option('tweetmp_secret', $tweetmp_Secret);
	add_option('tweetmp_consumerkey', $tweetmp_Ckey);
	add_option('tweetmp_consumersecret', $tweetmp_Csecret);
}
function tweetmp_uninstall() {
	delete_option('tweetmp_token');
	delete_option('tweetmp_secret');
	delete_option('tweetmp_consumerkey');
	delete_option('tweetmp_consumersecret');
}
add_action('admin_init', 'Tweetmp_init');
add_action('admin_menu', 'tweetmp_menu');
add_action('publish_post', 'tweetmypost');
add_action('admin_print_styles', 'addTweetmpStyle');
register_activation_hook(__FILE__, 'tweetmp_install');
register_deactivation_hook( __FILE__, 'tweetmp_uninstall' );
?>