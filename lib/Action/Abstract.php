<?php
/**
 * Created by PhpStorm.
 * User: carvincai
 * Date: 14-3-31
 * Time: ÏÂÎç4:37
 */

/**
 * Class Action_Abstract
 */
abstract class Action_Abstract extends UserAppFrame {
    protected $_result = null;

    protected $_model = null;

    protected $_request = null;
    protected $_response = null;

    protected $_validateFields = array();

    /**
     * JSON response content
     *
     * @var array
     */
    protected $_content = array();

    /**
     * GetConfig() must be overwritten.
     */
    public function GetConfig() {
        return System_Config::getGlobalConfig();
    }

    /**
     * StartApp() must be overwritten.
     *
     * @return mixed
     */
    public function StartApp() {
        $this->_request  = new Zend_Controller_Request_Http();
        $this->_response = new Zend_Controller_Response_Http();
    }

    public function getRequest() {
        return $this->_request;
    }

    public function getResponse() {
        return $this->_response;
    }

    public function GetLogName() {
        return basename(__FILE__);
    }

    public function GetConfigNode() {
        return null;
    }

    public function outputFileJson($ret, $msg, $domain = 'qq.com') {
        $this->_result = array(
            'ret_code' => $ret,
            'msg'      => is_string($msg) ? System_Encoding::GBKtoUTF8($msg) : $msg,
        );

        if (isset($domain) && $domain !== '') {
            echo $this->CgiOutput->GetOutputStream() . 'document.domain = "' . $domain . '";';
        }
        echo $this->CgiOutput->GetOutputStream() . "var {$this->GetConfigNode()}_RES = " . json_encode($this->_result);
    }

    public function outputMessageBox($ret, $msg) {
        echo $this->CgiOutput->MessageBox($msg);
    }

    protected function _validateFieldsForData($data) {
        foreach ($this->_validateFields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                throw new Action_Exception();
            }
        }
    }
}