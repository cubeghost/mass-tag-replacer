<?php
// Start a session, load the library
session_start();
require_once('tumblroauth/tumblroauth.php');

// Define the needed keys
$consumer_key = "YOUR CONSUMER KEY GOES HERE";
$consumer_secret = "PUT THE SECRET KEY HERE";
$oauth_token = 'YOUR oauth_token FROM callback.php RESPONSE GOES HERE';
$oauth_token_secret = 'YOUR oauth_token_secret FROM callback.php RESPONSE GOES HERE';
$base_hostname = 'YOUR TUMBLR BLOG URL GOES HERE';

//posting URI - http://www.tumblr.com/docs/en/api/v2#posting
$post_URI = 'http://api.tumblr.com/v2/blog/'.$base_hostname.'/post';

$tum_oauth = new TumblrOAuth($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);

// Make an API call with the TumblrOAuth instance. For text Post, pass parameters of type, title, and body
$parameters = array();
$parameters['type'] = "text";
$parameters['title'] = "title text";
$parameters['body'] = "body text";

$post = $tum_oauth->post($post_URI,$parameters);
//var_dump($tum_oauth);
echo "<br><br>";
var_dump($post);

// Check for an error.
if (201 == $tum_oauth->http_code) {
  echo $post->meta->msg;
  echo "<br>id:".$post->response->id;
} else {
  //die('error');
  var_dump($post);
}

?>