<?php
/**
 * Created by PhpStorm.
 * User: carvincai
 * Date: 14-3-31
 * Time: ÏÂÎç4:38
 */


/**
 * Class Action_Post
 */
class Action_Post extends Action_Abstract {
    protected $_validateFields = array(
        'title', 'content', 'uid',
    );

    public function GetConfigNode() {
        return 'MSG_POST';
    }

    public function GetLogName() {
        return basename(__FILE__);
    }

    public function StartApp() {
        parent::StartApp();

        if (!$this->_request->isPost()) {
            throw new Action_Exception(Action_Exception::ERROR_POST_METHOD_REQUIRED);
        }

        $this->_model = new Model_Message();

        $data = $this->_request->getPost();

        $this->_validateFieldsForData($data);

        $data = System_Encoding::UTF8toGBK($data);

        $this->_model->insertRow($data);

        $data['created'] = date('Y-m-d H:i:s');

        $this->_content = array(
            'count'  => 1,
            'result' => Helper_List::getHtmlForSingleMessage($data),
        );

        $this->_response->setHeader(System_Constant::SYSTEM_HTTP_CONTENT_TYPE, System_Constant::SYSTEM_HTTP_RESPONSE_JSON)
            ->appendBody(Zend_Json::encode(System_Encoding::GBKtoUTF8($this->_content)))
            ->sendResponse();
    }
}