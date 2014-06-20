<?php

define('ROOT', dirname(dirname(__FILE__)));
define('DS',   DIRECTORY_SEPARATOR);

define('APP',        ROOT.DS.'Application');
define('FRAMEWORK',  ROOT.DS.'Framework');
define('CORE',       FRAMEWORK.DS.'Core');
define('SERVICES',   FRAMEWORK.DS.'Services');
define('COMPONENTS', FRAMEWORK.DS.'Components');

define('CONTROLLERS', APP.DS.'Controllers');
define('MODELS',      APP.DS.'Models');
define('VIEWS',       APP.DS.'Views');
define('LAYOUTS',     APP.DS.'Layouts');

define('WEB', dirname(__FILE__));
define('VENDORS', ROOT.DS.'Vendors');
define('PLUGINS', ROOT.DS.'Plugins');
define('CONFIG',  ROOT.DS.'Config');
define('CACHE',  ROOT.DS.'Cache');

require_once FRAMEWORK.DS.'Autoload.php';

new Request();
