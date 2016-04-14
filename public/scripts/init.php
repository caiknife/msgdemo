<?php
/**
 * Created by PhpStorm.
 * User: carvincai
 * Date: 14-3-31
 * Time: ÏÂÎç3:29
 */
define('APP_ENV', 'dev');

if (APP_ENV === 'dev') {
    ini_set('display_errors', 'on');
    error_reporting(E_ALL);
}

/**
 * define path
 */
define('DEMO_ROOT_PATH', dirname(dirname(dirname(__FILE__))));
define('DEMO_CONFIG_PATH', DEMO_ROOT_PATH . '/config');
define('DEMO_LIB_PATH', DEMO_ROOT_PATH . '/lib');

/**
 * set include path
 */
set_include_path(DEMO_LIB_PATH . PATH_SEPARATOR . get_include_path());

/**
 * load oss
 */
require_once 'osslib.inc.php';
spl_autoload_register('__autoload');

/**
 * set autoloader
 */
require_once DEMO_LIB_PATH . '/Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance()->setFallbackAutoloader(true);

/**
 * set global config
 */
$config = new Zend_Config_Ini(DEMO_CONFIG_PATH . '/config.ini');
Zend_Registry::set(System_Config::SYSTEM_GLOBAL_CONFIG, $config);