<?php
/**
 * Created by PhpStorm.
 * User: carvincai
 * Date: 14-4-2
 * Time: ÉÏÎç11:40
 */

/**
 * Class Helper_Abstract
 */
abstract class Helper_Abstract {
    public static function h($text) {
        if (is_array($text)) {
            $texts = array();
            foreach ($text as $k => $t) {
                $texts[$k] = self::h($t);
            }
            return $texts;
        }
        return htmlspecialchars($text);
    }

    public static function nl2br($text) {
        return nl2br($text);
    }
}