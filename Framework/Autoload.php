<?php

function __autoload($name)
{
	if(file_exists(CORE.DS.$name.'.php'))
		require_once CORE.DS.$name.'.php';

	elseif(file_exists(SERVICES.DS.$name.'.php'))
		require_once SERVICES.DS.$name.'.php';

	elseif(file_exists(COMPONENTS.DS.$name.'.php'))
		require_once COMPONENTS.DS.$name.'.php';

	elseif(file_exists(MODELS.DS.$name.'.php'))
		require_once MODELS.DS.$name.'.php';

	elseif(file_exists(CONTROLLERS.DS.$name.'.php'))
		require_once CONTROLLERS.DS.$name.'.php';

	elseif(file_exists(VIEWS.DS.$name.'.php'))
		require_once VIEWS.DS.$name.'.php';
}
