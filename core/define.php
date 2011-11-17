<?php
		define('VERSION', 1.0);
		define('WRITR_LOADED',1);
		define('WRITR_PREFIX','');
		define('WRITR_CHARSET','utf-8');
		define('DIR_PARENT', "../");
		define('DIR_HELPERS', "helpers");
		define('DIR_MODELS', "models");
		define('DIR_CSS', "css");
		define('DIR_JS', "js");
		define('DIR_CORE', "core");
		define('DIR_CORE_HELPERS', "core/helpers");
		define('DIR_CORE_INSTALL', "core/install");
		define('DIR_CORE_MODELS', "core/models");
		define('DIR_CORE_CSS', "core/css");
		define('DIR_CORE_JS', "core/js");
		define('ROOT', str_replace('core/define.php', '', __file__));//define everything
		require ROOT.'/config.php';
		require ROOT.'core/helpers/load.php';//get the loader
		load::model('post');
		load::model('config');
		load::model('user');
	?>