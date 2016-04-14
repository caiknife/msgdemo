<?php
/**
 * Created by PhpStorm.
 * User: carvincai
 * Date: 14-3-31
 * Time: 下午4:23
 */

/**
 * Class Model_Message
 */
class Model_Message extends Model_Abstract {
    const TABLE_NAME = 'message_board';

    public function __construct($table = null) {
        if ($table === null) {
            parent::__construct(self::TABLE_NAME);
        } else {
            parent::__construct($table);
        }
    }

    public function getAll() {
        /**
         * 列出所有数据，没有分页，测试使用
         */
        $sql = "SELECT `title`, `content`, `created`, `modified`,`uid`, `nickname` FROM {$this->_table} "
            . "ORDER BY `created` DESC, `id` DESC;";
        $ret = $this->_db->ExecQuery($sql, $result);

        $return = array(
            'count'  => $ret,
            'result' => $result,
        );

        return $return;
    }

    public function getOne($id) {
        /**
         * 根据 id 查找单条数据
         */
        $sql = "SELECT `title`, `content`, `created`, `uid` FROM {$this->_table} "
            . "WHERE `id`={$id};";

        $ret = $this->_db->ExecQuery($sql, $result);

        if (empty($result)) {
            $return = array(
                'count'  => 0,
                'result' => array(),
            );
        } else {
            $return = array(
                'count'  => 1,
                'result' => $result[0],
            );
        }

        return $return;
    }

    public function getLimit($offset, $limit, $useCache = true) {
        $sql = "SELECT `title`, `content`, `created`, `modified`,`uid`, `nickname` FROM {$this->_table} "
            . "ORDER BY `created` DESC, `id` DESC LIMIT {$offset}, {$limit};";

        $return = System_Cache::load($sql);
        if (!$return || !$useCache) {
            $ret    = $this->_db->ExecQuery($sql, $result);
            $return = array(
                'cached' => false,
                'count'  => $ret,
                'result' => $result,
            );
            System_Cache::save($sql, $return);
        } else {
            $return['cached'] = true;
        }
        return $return;
    }
}