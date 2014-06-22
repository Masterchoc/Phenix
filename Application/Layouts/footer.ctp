	{IF:Config::$app->environment == 'DEV'}
		{debug_bar|raw}
	{ENDIF:}
	{IF:Config::$app->environment == 'DEV'}
		{@script rainbow.min.js}
	{ENDIF:}

	{@script vendor/modernizr.js}
	{@script vendor/jquery.js}
	{@script foundation.min.js}
	{@script app.js}

	<script>$(document).foundation();</script>
	</body>
</html>