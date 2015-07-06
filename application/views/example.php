<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Pusher Test</title>

	<!--
	This example view uses the Pusher Javascript SDK to subscribe
	on new events. https://github.com/pusher/pusher-js
	-->

	<script src="//js.pusher.com/2.2/pusher.min.js" type="text/javascript"></script>
</head>
<body>

	<script type="text/javascript">
		// Enable pusher logging - don't include this in production
		Pusher.log = function(message) {
			if (window.console && window.console.log) {
				window.console.log(message);
			}
		};

		var pusher = new Pusher('<your-pusher-app-key-here>');
		var channel = pusher.subscribe('test_channel');

		channel.bind('my_event', function(data) {
			document.getElementById('event').innerHTML = data.message;
			alert(data.message);
		});
	</script>

	<p id="event">Waiting on event...</p>
	<p>Go to <strong><a href="/example/trigger_event" target="_blank">/example/trigger_event</a></strong> in a new tab to trigger event.</p>

</body>
</html>
