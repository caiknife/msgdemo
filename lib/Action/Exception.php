<?php
/**
 * Created by PhpStorm.
 * User: carvincai
 * Date: 14-4-1
 * Time: 下午5:05
 */

/**
 * Class Action_Exception
 */
class Action_Exception extends Exception {
    const ERROR_POST_METHOD_REQUIRED = '必须使用 POST 方法！';
    const ERROR_FIELDS_MISSED        = '字段缺失，不能通过验证！';
}