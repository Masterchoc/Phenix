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