<?php
session_start();
require_once('tumblroauth/tumblroauth.php');

$blog = $_POST['blog'];
$postID = $_POST['postID'];
$tags = stripslashes($_POST['tags']);

	
$consumer_key = "InX4htB6aWBNaRlqUdlCUaA6l0fNLDzb0UPMEYPxfACSXraANO";
$consumer_secret = "4l0R3otgbwFLu6Qj5DgmZbRkvElr1YbgVojsv19pRimTxykJFx";

$oauth_token = $_COOKIE['o_token_2222'];
$oauth_token_secret = $_COOKIE['o_token_secret_2222'];


$api_edit_base = 'http://api.tumblr.com/v2/blog/'.$blog.'.tumblr.com/post/edit';

$edit_oauth = new TumblrOAuth($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);

// Make an API call with the TumblrOAuth instance. For text Post, pass parameters of type, title, and body
$parameters = array();
$parameters['id'] = $postID;
$parameters['tags'] = $tags;

$editpost = $edit_oauth->post($api_edit_base,$parameters);


?>
