<?php
/**
 * Created by PhpStorm.
 * User: carvincai
 * Date: 14-4-1
 * Time: 上午10:40
 */

/**
 * Class System_Config
 */
class System_Config extends System_Abstract {
    const SYSTEM_GLOBAL_CONFIG = 'globalConfig';

    /**
     * global config
     *
     * @var null
     */
    protected static $_config = null;

    /**
     * database instance
     *
     * @var null
     */
    protected static $_db = null;

    /**
     * @return array
     */
    public static function getGlobalConfig() {
        if (self::$_config === null) {
            $config        = Zend_Registry::get(self::SYSTEM_GLOBAL_CONFIG);
            self::$_config = $config->toArray();
        }
        return self::$_config;
    }

    public static function getDB() {
        if (self::$_db === null) {
            $config    = self::getGlobalConfig();
            self::$_db = new DBMysql($config['DATABASE']['host'], $config['DATABASE']['user'],
                $config['DATABASE']['password'], $config['DATABASE']['database']);
            /**
             * 设置数据库编码，必须用事务实现，巨坑 T_T
             */
            try {
                self::$_db->ExecTrans(array("SET NAMES {$config['DATABASE']['encoding']};"));
            } catch (Exception $e) {
                // do nothing
            }
        }
        return self::$_db;
    }
}