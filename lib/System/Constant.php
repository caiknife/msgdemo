<?php
/**
 * Created by PhpStorm.
 * User: carvincai
 * Date: 14-4-1
 * Time: ионГ10:47
 */

/**
 * Class System_Constant
 */
class System_Constant extends System_Abstract {
    const SYSTEM_ENCODING_GBK  = 'GBK';
    const SYSTEM_ENCODING_UTF8 = 'UTF8';

    const SYSTEM_LOG_FILE_PATH   = '/usr/local/appsweb/log/carvincai/demo/log/';
    const SYSTEM_CACHE_FILE_PATH = '/usr/local/appsweb/log/carvincai/demo/cache/';

    const SYSTEM_PAGINATION_NUMBER = 10;

    const SYSTEM_HTTP_CONTENT_TYPE   = 'Content-Type';
    const SYSTEM_HTTP_CONTENT_LENGTH = 'Content-Length';

    const SYSTEM_HTTP_RESPONSE_HTML  = 'text/html';
    const SYSTEM_HTTP_RESPONSE_XML   = 'text/html';
    const SYSTEM_HTTP_RESPONSE_PLAIN = 'text/plain';
    const SYSTEM_HTTP_RESPONSE_JSON  = 'application/json';

    const SYSTEM_HTTP_STATUS_200 = 200;
    const SYSTEM_HTTP_STATUS_201 = 201;

    const SYSTEM_HTTP_STATUS_300 = 300;
    const SYSTEM_HTTP_STATUS_301 = 301;
    const SYSTEM_HTTP_STATUS_302 = 302;
    const SYSTEM_HTTP_STATUS_304 = 304;

    const SYSTEM_HTTP_STATUS_400 = 400;
    const SYSTEM_HTTP_STATUS_404 = 404;

    const SYSTEM_HTTP_STATUS_500 = 500;
    const SYSTEM_HTTP_STATUS_502 = 502;
    const SYSTEM_HTTP_STATUS_503 = 503;
    const SYSTEM_HTTP_STATUS_504 = 504;

    const SYSTEM_TIME_MINUTE = 60;
    const SYSTEM_TIME_HOUR   = 3600;
    const SYSTEM_TIME_DAY    = 86400;
    const SYSTEM_TIME_MONTH  = 2073600;
    const SYSTEM_TIME_YEAR   = 756864000;
}