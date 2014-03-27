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

if ($handle = opendir('./txt/')) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") {
			$fileContent = file_get_contents('./txt/' . $file);
            $txt[$file] = $fileContent;
        }
    }
    closedir($handle);
}


//echo $api_call_base;

?>
<!--tags.goose.im version-->
<!-- made by goose (alex baldwin) in october 2013 for the benefit of the greater good, especially the greater good who made their selfie tag something weird 4 years ago and really want to change it now, and for fandom bloggers who accidentally started an x-men tag before realizing tags with -'s are invalid-->
<head>
	<title>mass tag replacer</title>
	<meta name="description" content="a mass tag replacer/editor for tumblr- takes every post on your blog tagged with one tag and replaces that tag with another.">
	
	<link href="tagreplaceicon.png" rel="icon" type="image/png" />
	
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="jquery.cookie.js"></script>
	
	
	<script type="text/javascript">
	$(document).ready(function(){
	
	$('header h2').click(function(){
		window.location='/';
	});
	
	var showcookie = $.cookie('showImportantThings');
	if (showcookie == 'no') {
		$('.ok').hide();
	} else {
		$('section.important').show();
		$('section.important').css({'opacity':1});
	}
	
	$('#important').click(function(){
        var section = $("section.important")
        if(section.is(':visible')){
            $('section.important').fadeTo('normal','0.02', function() { $('section.important').slideUp(); });
        }
        else{
            $('section.important').slideDown('normal', function() { $('section.important').fadeTo('normal','1'); });
        }
        event.preventDefault();
	});
	$('#info').click(function(){
        var section = $("section.info")
        if(section.is(':visible')){
            $('section.info').fadeTo('normal','0.02', function() { $('section.info').slideUp(); });
        }
        else{
            $('section.info').slideDown('normal', function() { $('section.info').fadeTo('normal','1'); });
        }
        event.preventDefault();
	});
	$('.ok').click(function(){
		//fade out .important
		var section = $("section.important")
        if(section.is(':visible')){
            $('section.important').fadeTo('normal','0.02', function() { $('section.important').slideUp(); });
        }
        else{
            $('section.important').slideDown('normal', function() { $('section.important').fadeTo('normal','1'); });
        }
        //fade out button
		$('.ok').fadeOut('normal');
		//set cookie so this doesn't happen again
		$.cookie('showImportantThings','no');

        event.preventDefault();
	});
	
	
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
	
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,300,400italic,400' rel='stylesheet' type='text/css'>
	<style type="text/css">
	* {margin:0;border:0;padding:0;}
	html {height:100%;}
	body {
		background: -moz-linear-gradient(top, #30c6e2 0%, #ffa9c9 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#30c6e2), color-stop(100%,#ffa9c9)); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top, #30c6e2 0%,#ffa9c9 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top, #30c6e2 0%,#ffa9c9 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top, #30c6e2 0%,#ffa9c9 100%); /* IE10+ */
		background-attachment:fixed;
		font-family:'Open Sans',Helvetica,sans-serif;
		padding:0;	
		color:#fff;
		font-weight:300;
		letter-spacing:0.2px;
		word-spacing:0.5px;
		overflow-y:hidden;
	}
	h1,h2 {font-weight:300;font-size:2.5em;}
	h1 {margin-top:10%;}
	a {color:#111;}
	p {padding:10px 0 0 0;}
	ul {padding-left:30px;padding-top:10px;}
	li {padding:5px;}
	.button {text-decoration:none;-webkit-border-radius:8px;-moz-border-radius:8px;border-radius:8px;padding:12px 24px;margin:1.3em 0;display:inline-block;border:2px #fff solid;font-size:1.6em;color:#fff;font-weight:300;opacity:0.9;}
	.button:hover {opacity:1;-webkit-transition:all linear 150ms;}
	input {padding:12px 12px;font-size:1.5em;-webkit-border-radius:8px;-moz-border-radius:8px;border-radius:8px;display:inline;border:2px #fff solid;background:none;font-weight:300!important;font-family:'Open Sans';opacity:0.8;color:#fff;width:270px;margin-bottom:0;margin-top:30px;}
	input:nth-child(odd) {margin:30px 30px 0 0;}
	input:focus {outline:none;opacity:1;}
	form {margin-top:15px;}
	#postids {max-height:60px;overflow:scroll;}
	form label {float:right;opacity:0.5;}
	code {background:rgba(255,255,255,0.2);padding-top:10px;}
	p.front {font-size:1.3em;max-width:600px;padding-top:1.3em;}
	::-webkit-input-placeholder {color:rgba(255,255,255,0.7);}
	:-moz-placeholder {color:rgba(255,255,255,0.7);}
	::-moz-placeholder {color:rgba(255,255,255,0.7);}
	:-ms-input-placeholder {color:rgba(255,255,255,0.7);}
	.button.go {padding:10px 12px 11px 12px;width:63px;opacity:0.8;cursor:pointer;}
	.button.go:hover {opacity:1;}
	b {font-weight:400;}
	header {background:rgba(255,255,255,0.2);width:100%;}
	header h2 {padding:0.6em 0.8em 0.8em 0.8em;cursor:pointer;width:350px;}
	section.center {margin:0 auto;}
	section.form {width:700px;}
	section.row.top {width:600px;}
	section.row.bottom {width:373px;margin-left:304px;}
	section.nav {float:right;color:#fff;font-size:1.5em;margin-top:-70px;}
	section.nav a {text-decoration:none!important;color:#fff;margin-right:30px;}
	a#settings {color:#fff;text-decoration:none;position:relative;width:90px;left:50%;margin-left:-45px;bottom:10px;}
	h3 {font-weight:300;font-style:italic;font-size:1.3em;}
	section.big {width:75%;border-radius:8px;-moz-border-radius:8px;-webkit-border-radius:8px;border:2px #fff solid;margin-top:50px;padding:18px 20px 20px 20px;}
	section.big section.column {width:48%;}
	section.column.left {float:left;border-right:#fff 2px solid;padding-right:1.5%;}
	section.column.right {float:right;}
	section.big.info {display:none;opacity:0;}
	section.big.important {display:none;opacity:0;}
	section.big.info h3 {text-align:center;border-bottom:2px #fff solid;padding-bottom:15px;margin-bottom:20px;margin-top:-5px;}
	section.big .button {font-size:1em;padding:12px;margin-bottom:0;margin-top:20px;}
	.clear {display:block;clear:both;}
	p.footer {opacity:0.7;font-size:12px;position:absolute;bottom:10px;left:50%;text-indent:-215px;}
	</style>
	
</head>

<body>
	<div class="alpha">
		<?php
			if (empty($oauth_token)) {
				echo $txt['front.txt'];				

			} else {
				echo '<header>
							<h2>mass tag replacer</h2>
							<section class="nav">
								<a href="#" id="important">instructions+bugs</a>
								<a href="#" id="info">info</a>
								<a href="clearcookie.php">log out</a>
							</section>
						</header>
						<section class="center big important">';
						echo $txt['instructions.txt'];
						echo $txt['bugs.txt'];
						echo '<span class="clear">
						<center><a class="button ok" href="#">ok, got it!</a></center>
						</section>
						<section class="center big info">';
						echo $txt['info.txt'];
						echo '<span class="clear"></section> 
						<section class="form center">
						<form name="opt" id="opt" action="http://tags.goose.im/" method="POST">
							<section class="row top">
								<input type="text" placeholder="blog" name="blog">
								<input type="text" placeholder="find" name="tagIn">
							</section>
							<section class="row bottom">
								<input type="text" placeholder="replace" name="tagOut">
								<input type="submit" value="go" class="button go">
							</section>
						</form>
						</section>
						<code id="postids"></code>';
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