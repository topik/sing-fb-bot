<?php
/**
 * @author Tomas Opekar <tomas.opekar@golemos.com>
 * @copyright Golemos s.r.o. 02.4.2017
 */
?>
<html>
<head>
	<title>SingSing.tv Facebook bot</title>
	<meta property="og:url" content="http://www.your-domain.com/your-page.html"/>
	<meta property="og:type" content="website"/>
	<meta property="og:title" content="Your Website Title"/>
	<meta property="og:description" content="Your description"/>
	<meta property="og:image" content="http://www.your-domain.com/path/image.jpg"/>
</head>
<body>

<div id="fb-root"></div>
<script>(function (d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s);
		js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-send-to-messenger"
	messenger_app_id="794513414046328"
	page_id="616975015150191"
	data-ref="gimme322"
	color="blue"
	size="xlarge"></div>

</body>
</html>
