{@doctype 5}
<html class="no-js" lang="fr">
	<head>
		{@meta viewport}
		{@meta charset}
		{@meta description $config_appDescription}
		
		{@title}

		{@css foundation.css}
		{@css phenix.css}

		{IF:Config::$app->environment == 'DEV'}
			{@css highlight.css}
		{ENDIF:}
	</head>
	<body>
		<nav class="top-bar" data-topbar>
			<ul class="title-area">
				<li class="name">
					<h1 {IF:!empty($this->data['config_appSubName'])}class="fix"{ENDIF:}>
					<a href="/">{config_appName}<br>{config_appSubName}</a>
					</h1>
				</li>
			</ul>
			{@menu top-bar-section left}
		</nav>

		<div class="row">
			{content_for_layout|raw}
		</div>

		<div class="footer">
			{IF:Config::$app->environment == 'DEV'}
				{debug_bar|raw}
			{ENDIF:}
		</div>

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