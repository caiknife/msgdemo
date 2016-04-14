<?php
/**
 * Created by PhpStorm.
 * User: carvincai
 * Date: 14-4-1
 * Time: 下午5:05
 */

/**
 * Class Model_Exception
 */
class Model_Exception extends Exception {
    const ERROR_INSERT_EMPTY_ROW = '不能插入空数据！';

    const ERROR_UPDATE_EMPTY_ROW = '不能更新空数据！';
    const ERROR_UPDATE_EMPTY_ID  = '没有传递主键！';
}