<?php
/**
 * Created by PhpStorm.
 * User: carvincai
 * Date: 14-3-31
 * Time: ����4:38
 */

/**
 * Class Action_List
 */
class Action_List extends Action_Abstract {
    const OFFSET      = 'offset';
    const CLEAR_CACHE = 'clearcache';

    protected $_offset = 0;
    protected $_clearCache = false;
    protected $_hasPrev = false;
    protected $_hasNext = false;

    public function GetConfigNode() {
        return 'MSG_LIST';
    }

    public function GetLogName() {
        return basename(__FILE__);
    }

    public function StartApp() {
        parent::StartApp();

        $this->_offset     = $this->_request->getQuery(self::OFFSET, 0);
        $this->_clearCache = $this->_request->getQuery(self::CLEAR_CACHE, false);

        $this->_model = new Model_Message();

        if ($this->_clearCache) {
            System_Cache::clean();
        }

        /**
         * ���һ����������û����һҳ
         */
        $result = $this->_model->getLimit($this->_offset, System_Constant::SYSTEM_PAGINATION_NUMBER + 1);

        if ($result['count'] > System_Constant::SYSTEM_PAGINATION_NUMBER) {
            $result['return'] = $result['count'] - 1;
            array_pop($result['result']);
            $this->_hasNext = true;
        } else {
            $result['return'] = $result['count'];
        }

        if ($this->_offset > 0) {
            $this->_hasPrev = true;
        }

        /**
         * @cached �Ƿ񾭹�����
         * @request ��������������Ĭ�� 11
         * @count ���ݿ�ʵ�ʷ�������
         * @return ҳ����Ҫ������Ĭ�� 10
         * @offset ����ƫ����
         * @result ��������
         * @prev ��ǰ��ҳ�������
         * @next ���ҳ�������
         */
        $this->_content = array(
            'cached'  => $result['cached'],
            'request' => System_Constant::SYSTEM_PAGINATION_NUMBER + 1,
            'count'   => $result['count'],
            'return'  => $result['return'],
            'offset'  => $this->_offset,
            'result'  => Helper_List::getHtmlForMessages($result['result']),
            'prev'    => array(
                'hasPrev' => $this->_hasPrev,
                'offset'  => $this->_offset - System_Constant::SYSTEM_PAGINATION_NUMBER,
            ),
            'next'    => array(
                'hasNext' => $this->_hasNext,
                'offset'  => $this->_offset + System_Constant::SYSTEM_PAGINATION_NUMBER,
            ),

        );

        $this->_response->setHeader(System_Constant::SYSTEM_HTTP_CONTENT_TYPE, System_Constant::SYSTEM_HTTP_RESPONSE_JSON)
            ->appendBody(Zend_Json::encode(System_Encoding::GBKtoUTF8($this->_content)))
            ->sendResponse();
    }

}