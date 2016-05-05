<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Don't Blink</title>
<link rel="apple-touch-icon" sizes="57x57" href="favicons/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" sizes="114x114" href="favicons/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="72x72" href="favicons/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="144x144" href="favicons/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="60x60" href="favicons/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="120x120" href="favicons/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="76x76" href="favicons/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="152x152" href="favicons/apple-touch-icon-152x152.png">
<link rel="icon" type="image/png" href="favicons/favicon-196x196.png" sizes="196x196">
<link rel="icon" type="image/png" href="favicons/favicon-160x160.png" sizes="160x160">
<link rel="icon" type="image/png" href="favicons/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/png" href="favicons/favicon-16x16.png" sizes="16x16">
<link rel="icon" type="image/png" href="favicons/favicon-32x32.png" sizes="32x32">
<meta name="msapplication-TileColor" content="#111111">
<meta name="msapplication-TileImage" content="favicons/mstile-144x144.png">
<meta property="twitter:card" content="summary" />
<meta property="twitter:site" content="@vbloke" />
<meta property="twitter:title" content="Don't Blink" />
<meta property="twitter:description" content="Blink and you're dead." />
<meta property="twitter:image" content="http://dont-blink.herokuapp.com/img/9.jpg" />
<meta property="twitter:url" content="http://dont-blink.herokuapp.com/" />
<meta property="og:title" content="Don't Blink" />
<meta property="og:type" content="app" />
<meta property="og:image" content="http://dont-blink.herokuapp.com/img/9.jpg" />
<meta property="og:url" content="http://dont-blink.herokuapp.com/" />
<meta property="og:description" content="Blink and you're dead." />
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:800" rel="stylesheet" type="text/css">
</head>
<body>
<span id="timestamp" data-livestamp=""></span>
<span id="timestamp2" data-livestamp=""></span>
<div id="img"><img src="" alt="0" width="500" height="281"></div>

<video id="video"></video>

<script src="js/compatibility.js"></script>
<script src="js/smoother.js"></script>
<script src="js/objectdetect.js"></script>
<script src="js/objectdetect.frontalface.js"></script>
<script src="js/objectdetect.eye.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="js/jquery.objectdetect.js"></script>
<script src="js/timeago.js"></script>
<script src="//platform.twitter.com/widgets.js"></script>
<script>

$(function() {
	var now = moment();
	$('#timestamp').attr('data-livestamp', now);
});
var smoother = new smoother([0.9999, 0.9999, 0.9, 0.9], [0, 0, 0, 0, 0]);
$(window).load(function() {

	var startTime = new Date().valueOf(),
		numberWang = 0,
		imgs = 'img/'+numberWang+'.jpg',
		angel = $('#img img').attr('src'),
		video = $('#video').get(0);;
	angel = $('#img img').attr('src', imgs);
	try {
		compatibility.getUserMedia({video: true}, function(stream) {
			try {
				video.src = compatibility.URL.createObjectURL(stream);
			} catch (error) {
				video.src = stream;
			}
			compatibility.requestAnimationFrame(tick);
		}, function (error) {
			alert('WebRTC not available');
		});
	} catch (error) {
		alert(error);
	}
	function tick() {
		compatibility.requestAnimationFrame(tick);
		if (video.paused) video.play();
		if (video.readyState === video.HAVE_ENOUGH_DATA) {
			$(video).objectdetect('all', {scaleMin: 3, scaleFactor: 1.1, classifier: objectdetect.frontalface}, function(faces) {
				for (var i = 0; i < faces.length; ++i) {
					$(this).objectdetect('all', {classifier: objectdetect.eye, selection: faces[i]}, function(eyes) {
						if(eyes[0]){
							for (var j = 0; j < eyes.length; ++j) {}
						} else {
							++numberWang;
							if(numberWang == 11){
								var then = moment();
								$('#timestamp2').attr('data-livestamp', then);
								var now = $('#timestamp').attr('data-livestamp');
								var difference = (then - now)/1000;
								$('#img').html('<h2>I lasted '+difference+' seconds against the Weeping Angels</h2><p><a href="https://twitter.com/intent/tweet?text=I lasted '+difference+' seconds against the Weeping Angels. Can you survive longer?%20&url=http%3A%2F%2Fweepingangels.herokuapp.com&hashtags=dontblink" class="tweet">Tweet your score</a></p><p><a href="#" onclick="location.reload(true); return false;">Try again?</a></p>');
							}
							console.log('blink');
							var imgs = 'img/'+numberWang+'.jpg';
							$('#img img').attr('src', imgs);
						}
					});
				}
			});
		}
	}
});

(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},
i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];
a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-53559666-1', 'auto');
ga('require', 'displayfeatures');
ga('send', 'pageview');
</script>
</body>
</html>