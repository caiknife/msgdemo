<?php
/**
 * Created by PhpStorm.
 * User: carvincai
 * Date: 14-4-1
 * Time: ����5:05
 */

/**
 * Class Action_Exception
 */
class Action_Exception extends Exception {
    const ERROR_POST_METHOD_REQUIRED = '����ʹ�� POST ������';
    const ERROR_FIELDS_MISSED        = '�ֶ�ȱʧ������ͨ����֤��';
}