<?php
/**
 * Created by PhpStorm.
 * User: carvincai
 * Date: 14-4-1
 * Time: ����5:05
 */

/**
 * Class Model_Exception
 */
class Model_Exception extends Exception {
    const ERROR_INSERT_EMPTY_ROW = '���ܲ�������ݣ�';

    const ERROR_UPDATE_EMPTY_ROW = '���ܸ��¿����ݣ�';
    const ERROR_UPDATE_EMPTY_ID  = 'û�д���������';
}