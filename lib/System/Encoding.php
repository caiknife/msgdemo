<?php
/**
 * Created by PhpStorm.
 * User: carvincai
 * Date: 14-4-1
 * Time: ионГ11:04
 */

/**
 * Class System_Encoding
 */
class System_Encoding extends System_Abstract {
    const GBK  = 'GBK';
    const UTF8 = 'UTF8';

    public static function GBKtoUTF8($item) {
        if (is_array($item)) {
            return array_map(array(__CLASS__, 'GBKtoUTF8'), $item);
        }
        return iconv(self::GBK, self::UTF8, $item);
    }

    public static function UTF8toGBK($item) {
        if (is_array($item)) {
            return array_map(array(__CLASS__, 'UTF8toGBK'), $item);
        }
        return iconv(self::UTF8, self::GBK, $item);
    }
}