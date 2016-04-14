<?php
/**
 * Created by PhpStorm.
 * User: carvincai
 * Date: 14-4-2
 * Time: ÉÏÎç11:42
 */

/**
 * Class Helper_List
 */
class Helper_List extends Helper_Abstract {
    public static function getHtmlForSingleMessage($item, $class = 'label') {
        $template = '<div class="well well-small">
  <div class="pull-right">
    <span class="' . $class . ' ' . $class . '-info">' . Helper_Abstract::h($item['nickname']) . '</span>
    <span class="' . $class . ' ' . $class . '-important">' . Helper_Abstract::h($item['uid']) . '</span>
    <span class="' . $class . ' ' . $class . '-warning">' . Helper_Abstract::h($item['created']) . '</span>
  </div>
  <h4>' . Helper_Abstract::h($item['title']) . '</h4>
  <div>
    <p>' . Helper_Abstract::nl2br(Helper_Abstract::h($item['content'])) . '</p>
  </div>
</div>';

        return $template;
    }

    public static function getHtmlForMessages($items) {
        $html = '';
        foreach ($items as $item) {
            $html .= self::getHtmlForSingleMessage($item);
        }
        return $html;
    }
}