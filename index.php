<?php 
session_start();
require_once('tumblroauth/tumblroauth.php');

$consumer_key = "InX4htB6aWBNaRlqUdlCUaA6l0fNLDzb0UPMEYPxfACSXraANO";
$consumer_secret = "4l0R3otgbwFLu6Qj5DgmZbRkvElr1YbgVojsv19pRimTxykJFx";

$oauth_token = $_COOKIE['o_token_2222'];
$oauth_token_secret = $_COOKIE['o_token_secret_2222'];

$blog = $_POST['blog'];
$tagIn = $_POST['tagIn'];
$tagOut = $_POST['tagOut'];
	
$api_call_base = 'http://api.tumblr.com/v2/blog/' . $blog . '.tumblr.com/posts?api_key=' . $consumer_key . '&tag=' . $tagIn;

$api_edit_base = 'http://api.tumblr.com/v2/blog/' . $blog . '.tumblr.com/post/edit/';

//echo $api_call_base;

?>
<!-- made by goose (alex baldwin) in october 2013 for the benefit of the greater good, especially the greater good who made their selfie tag something weird 4 years ago and really want to change it now, and for fandom bloggers who accidentally started an x-men tag before realizing tags with -'s are invalid-->
<head>
	<title>mass tag replacer</title>
	<meta name="description" content="a mass tag replacer/editor for tumblr- takes every post on your blog tagged with one tag and replaces that tag with another.">
	
	<link href="tagreplaceicon.png" rel="icon" type="image/png" />
	
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	
	<script type="text/javascript">
	$(document).ready(function(){
	
	var j;

	jsonpcallback = function(data) {

		j = data.response['total_posts'];
		j = j / 20;
		j = Math.round(j);
		
		console.log('total posts: '+data.response['total_posts']);
		
		i = 0;
		
//		for (i=0;i<j;i++) {
		function f() {
		setTimeout(function() { 

			var n = i * 20;
									
			var apiplus = "<?=$api_call_base;?>&offset=" + n;
						
			innerjsonp = function(data) {
				$.each(data.response.posts, function(i,post){
					var postID = this['id']; //
					var currentTags = this['tags'];
					$('#postids').append(postID+'('+currentTags+'), ');
					currentTags = currentTags.join();
					//var newTags = currentTags.replace('<?=$tagIn;?>','<?=$tagOut;?>')
					var pattern = new RegExp('<?=$tagIn;?>', 'gi');
					var newTags = currentTags.replace(pattern, '<?=$tagOut;?>');
					newTags = newTags.replace(/\\/g, '');
					console.log('replacing '+currentTags+' with '+newTags+'...');
					$.ajax({
						type: 'POST',
						url: 'retag.php',
						data: {
							blog: '<?=$blog;?>',
							postID: postID,
							tags: newTags
						}
					});				
				});
			
			}
			
			
			$.ajax({
				type: "GET",
				url: apiplus,
				dataType: "jsonp",
				data: {
					jsonp: "innerjsonp"
				}
			});
			
			i++
		
		if (i<j) {f();}

		},1500)		
		}
		
		f();
		
			
	}
			
	
	$.ajax({
		type: "GET",
		url: "<?=$api_call_base;?>",
		dataType: "jsonp",
		data: {
			jsonp: "jsonpcallback"
		}
	});


      
});


	</script>
	
	<link href='http://fonts.googleapis.com/css?family=Ubuntu:400,700' rel='stylesheet' type='text/css'>
	<style type="text/css">
	* {margin:0;border:0;padding:0;}
	html {height:100%;}
	body {
		background:radial-gradient(70% 150%, ellipse cover, #f5bed1 0%,#18c0c2 100%);
		background:-webkit-radial-gradient(70% 150%, ellipse cover, #f5bed1 0%,#18c0c2 100%);
		background:-moz-radial-gradient(70% 150%, ellipse cover, #f5bed1 0%,#18c0c2 100%);
		background:-o-linear-gradient(45deg,#f5bed1 0%,#18c0c2 100%) fixed;
		background:-ms-radial-gradient(70% 150%, ellipse cover, #f5bed1 0%,#18c0c2 100%);
		background-attachment:fixed;
		font-family:'Ubuntu',Helvetica,sans-serif;
		padding:0;	
		font-size:0.93em;
	}
	.alpha {width:740px;background:rgba(255,255,255,0.8);margin:30px auto;padding:30px;box-shadow:6px 6px 0px rgba(255,255,255,0.3);-webkit-transition:all linear 100ms;}
	.alpha:hover {box-shadow:12px 12px 0px rgba(255,255,255,0.3);}
	a {color:#111;}
	p {padding:10px 0 0 0;}
	ul {padding-left:30px;padding-top:10px;}
	li {padding:5px;}
	.button {text-decoration:none;background:rgba(255,255,255,0.9);-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;padding:8px;font-size:1.5em;margin-top:8px;display:inline-block;}
	.button:hover {background:rgba(24,192,194,0.4);-webkit-transition:all linear 100ms;}
	input {padding:8px;font-size:1.5em;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;display:block;background:rgba(255,255,255,0.6);margin:10px 0;}
	input:focus {background:#fff;outline:none;}
	form {margin-top:15px;}
	#postids {max-height:60px;overflow:scroll;}
	form label {float:right;opacity:0.5;}
	code {background:rgba(255,255,255,0.2);padding-top:10px;}
	</style>
	
</head>

<body>
	<div class="alpha">
		<?php
			if (empty($oauth_token)) {
				echo '<h2>mass tag replacer</h2>
						<p>this is what we\'ve all been waiting for. as you can probably guess, this is a script that can take a bunch of posts tagged with one thing and replace that tag with another. that\'s what it does! isn\'t that great?</p>
						<p><b>there are things you need to be aware of</b> before you use this:
						<ul>
							<li>in large groups of posts, <b>it doesn\'t get everything on the first try</b>. if it missed some posts, just do it again, maybe a third time. </li>
							<li>this doesn\'t currently work on ask posts. if you know why this is happening, let me know, because i definitely don\'t.</li>
							<li>as far as weird characters go: colons, spaces, hyphens, apostrophes, and both kinds of slashes <b>now work</b>. ampersands and many other odd characters probably don\'t. please use caution.</li>
							<li>i\'m a busy college student and don\'t have as much time to dedicate to this as i\'d like! but if you have questions, i\'m <a href="http://twitter.com/cubeghost/" target="_blank">@cubeghost</a> on twitter.</li>
						</ul></p>
						<p>alright, you ready?</p>
				<p><a href="connect.php" class="button">&#9728;&#9729; GO! &#9775;&#9788;</a></p>
				<p style="opacity:0.5;font-size:0.8em;padding-top:20px;">made by alex baldwin / goose.im. special thanks to <a href="http://techslides.com/tumblr-api-example-using-oauth-and-php/">techslides\' tumblroauth.php</a>.</p>';
			} else {
				echo '<h2>mass tag replacer: welcome, friend! (&#9697;&#8255;&#9697;&#10047;)</h2>
						<p><b>currently unsupported and buggy:</b> <strike>apostrophes (\'), slashes (/),</strike>parentheses (), brackets [], ampersands (&), ask posts, possibly other special characters. <b>spaces, colons, and now apostrophes and slashes are safe</b>.</p>
						<p>want to replace a tag with multiple tags? just separate them with commas.</p>
						<p>"blog url" refers to the part before .tumblr.com. if you have a custom domain please use your regular tumblr url instead of the domain.</p>
						<p>when entering the tag(s), leave out the #.</p>
						<form name="opt" id="opt" action="http://dev.goose.im/tags/" method="POST">
							<input type="text" placeholder="blog url" name="blog">
							<input type="text" placeholder="tag to find" name="tagIn">
							<input type="text" placeholder="tag to replace with" name="tagOut">
							<input type="submit" value="&#9762; replace &#9762;" class="button">
						</form>
						<p><a href="clearcookie.php">log out</a></p>
						<p style="opacity:0.5;font-size:0.8em;padding-top:20px;">did this help you? feel like helping out a college student in return? you can donate to me on paypal! spare change can be sent to <b>paypal@goose.im</b>. :)</p>
						<code id="postids"></code>
						
				';
			}
		?>
	</div>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-37168472-1']);
  _gaq.push(['_setDomainName', 'goose.im']);
  _gaq.push(['_setAllowLinker', true]);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</body>