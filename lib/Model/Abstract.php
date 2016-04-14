<?php
/**
 * Created by PhpStorm.
 * User: carvincai
 * Date: 14-3-31
 * Time: ÏÂÎç4:24
 */

/**
 * Class Model_Abstract
 */
abstract class Model_Abstract {
    /**
     * DB instance
     *
     * @var null
     */
    protected $_db = null;

    /**
     * table name
     *
     * @var null
     */
    protected $_table = null;

    public function __construct($table = null) {
        $this->_db = System_Config::getDB();
        if ($table !== null) {
            $this->setTable($table);
        }
    }

    public function setTable($table) {
        $this->_table = $table;
        return $this;
    }

    public function getTable() {
        return $this->_table;
    }

    public function setDatabase($database) {
        $this->_db->SetDatabase($database);
        return $this;
    }

    public function insertRow($data = array()) {
        if (empty($data)) {
            throw new Model_Exception(Model_Exception::ERROR_INSERT_EMPTY_ROW);
        }
        $data = (array) $data;

        if (!isset($data['created'])) {
            $data['created'] = date('Y-m-d H:i:s');
        }

        $fieldsArray = array_keys($data);
        $valuesArray = array_values($data);
        array_walk($fieldsArray, array($this, '_processInsertFields'));
        array_walk($valuesArray, array($this, '_processInsertValues'));
        $fields = implode(', ', $fieldsArray);
        $values = implode(', ', $valuesArray);

        $sql = "INSERT INTO {$this->_table} ({$fields}) VALUES ({$values});";

        return $this->_db->ExecUpdate($sql);

    }

    public function updateRow($data = array()) {
        if (empty($data)) {
            throw new Model_Exception(Model_Exception::ERROR_UPDATE_EMPTY_ROW);
        }
        if (!isset($data['id']) || empty($data['id'])) {
            throw new Model_Exception(Model_Exception::ERROR_UPDATE_EMPTY_ID);
        }
        $data = (array) $data;

        $id = $data['id'];
        unset($data['id']);

        array_walk($data, array($this, '_processUpdateValues'));
        $values = implode(', ', $data);

        $sql = "UPDATE {$this->_table} SET {$values} WHERE `id`={$id};";

        return $this->_db->ExecUpdate($sql);
    }

    protected function _processInsertFields(&$item, $key) {
        $item = "`{$item}`";
    }

    protected function _processInsertValues(&$item, $key) {
        $item = "'" . mysql_real_escape_string($item) ."'";
    }

    protected function _processUpdateValues(&$item, $key) {
        $item = "`{$key}`='" . mysql_real_escape_string($item) . "'";
    }

}