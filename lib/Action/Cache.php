<?php
/**
 * Created by PhpStorm.
 * User: carvincai
 * Date: 14-4-3
 * Time: ÉÏÎç9:45
 */

/**
 * Class Action_Cache
 */
class Action_Cache extends Action_Abstract {
    const CLEAR_CACHE = 'clearcache';

    protected $_clearCache = false;

    public function GetConfigNode() {
        return 'MSG_CACHE';
    }

    public function GetLogName() {
        return basename(__FILE__);
    }

    public function StartApp() {
        parent::StartApp();

        $this->_clearCache = $this->_request->getQuery(self::CLEAR_CACHE, false);

        $this->_content = array(
            'cache_cleared' => false,
        );

        if ($this->_clearCache) {
            System_Cache::clean();
            $this->_content['cache_cleared'] = true;
        }

        $this->_response->setHeader(System_Constant::SYSTEM_HTTP_CONTENT_TYPE, System_Constant::SYSTEM_HTTP_RESPONSE_JSON)
            ->appendBody(Zend_Json::encode(System_Encoding::GBKtoUTF8($this->_content)))
            ->sendResponse();
    }
}