<?php
/**
 * Created by PhpStorm.
 * User: carvincai
 * Date: 14-4-2
 * Time: ÏÂÎç3:10
 */

/**
 * Class System_Cache
 */
class System_Cache extends System_Abstract {
    protected static $_instance = null;
    protected $_cache = null;

    /**
     * __construct() and __clone() must set to protected or private for Singleton pattern
     * use Zend_Cache_Backend_File as cache system
     */
    protected function __construct() {
        $frontendOptions = array(
            'lifetime'                => System_Constant::SYSTEM_TIME_MINUTE * 5,
            'automatic_serialization' => true,
        );
        $backendOptions  = array(
            'cache_dir' => System_Constant::SYSTEM_CACHE_FILE_PATH,
        );

        $this->_cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
    }

    protected function __clone() {
    }

    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function getCache() {
        return $this->_cache;
    }

    public static function encrypt($key) {
        if (is_array($key)) {
            $key = serialize($key);
        }
        return md5($key);
    }

    public static function save($key, $value) {
        $key = self::encrypt($key);
        return self::getInstance()->getCache()->save($value, $key);
    }

    public static function load($key) {
        $key = self::encrypt($key);
        return self::getInstance()->getCache()->load($key);
    }

    public static function test($key) {
        $key = self::encrypt($key);
        return self::getInstance()->getCache()->test($key);
    }

    public static function remove($key) {
        $key = self::encrypt($key);
        return self::getInstance()->getCache()->remove($key);
    }

    public static function clean() {
        return self::getInstance()->getCache()->clean();
    }

}