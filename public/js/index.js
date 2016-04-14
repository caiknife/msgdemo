/**
 * Created by carvincai on 14-3-31.
 */
/**
 * global offset
 *
 * @type {number}
 */
var globalOffset = 0;

/**
 * Message Board function
 */
var MB = MessageBoard = {
    SYSTEM_CACHE_NAME: 'message_board_',

    SYSTEM_NOTY_ERROR: 'error',
    SYSTEM_NOTY_WARNING: 'warning',
    SYSTEM_NOTY_ALERT: 'alert',
    SYSTEM_NOTY_SUCCESS: 'success',
    SYSTEM_NOTY_INFORMATION: 'information',
    SYSTEM_NOTY_CONFIRM: 'confirm',
    SYSTEM_NOTY_TIMEOUT: 2000,

    SYSTEM_MESSAGE_POST_SUCCEED: '留言成功！',
    SYSTEM_MESSAGE_TITLE_REQUIRED: '请输入留言标题！',
    SYSTEM_MESSAGE_CONTENT_REQUIRED: '请输入留言内容！',
    SYSTEM_MESSAGE_LOGIN_REQUIRED: '您还没有登录！',
    SYSTEM_MESSAGE_CLEAR_CACHE_CONFIRM: '确定要清除缓存吗？',

    SYSTEM_LAYOUT_TOP: 'top',
    SYSTEM_LAYOUT_TOP_LEFT: 'topLeft',
    SYSTEM_LAYOUT_TOP_CENTER: 'topCenter',
    SYSTEM_LAYOUT_TOP_RIGHT: 'topRight',
    SYSTEM_LAYOUT_CENTER_LEFT: 'centerLeft',
    SYSTEM_LAYOUT_CENTER: 'center',
    SYSTEM_LAYOUT_CENTER_RIGHT: 'centerRight',
    SYSTEM_LAYOUT_BOTTOM_LEFT: 'bottomLeft',
    SYSTEM_LAYOUT_BOTTOM_CENTER: 'bottomCenter',
    SYSTEM_LAYOUT_BOTTOM_RIGHT: 'bottomRight',
    SYSTEM_LAYOUT_BOTTOM: 'bottom',

    init: function () {
        /**
         * Milo 登录
         */
        need('biz.login', function (LoginManager) {
            LoginManager.checkLogin(function () {
                g("login_qq_span").innerHTML = LoginManager.getUserUin();

                LoginManager.getNickName(function (loginInfo) {
                    if (loginInfo.isLogin) {
                        g("login_nickname_span").innerHTML = loginInfo.nickName;
                    }
                });
            });
        });

        /**
         * DNF 角色选择
         */
        need(["biz.roleselector"], function (RoleSelector) {
            RoleSelector.init({
                'gameId': 'dnf',
                'isQueryRole': true,
                'isShutdownSubmit': false,
                'submitEvent': function (roleObject) {
                    noty({
                        layout: MessageBoard.SYSTEM_LAYOUT_TOP_RIGHT,
                        type: MessageBoard.SYSTEM_NOTY_INFORMATION,
                        text: "您已经选择【" + roleObject.submitData.areaname + "】的角色【" + roleObject.submitData.rolename + "】"
                    });
                },
                'cancelEvent': function () {
                },
                'openEvent': function () {
                },
                'closeEvent': function () {
                }
            });
        });
    },

    loadCache: function (offset) {
        var key = MessageBoard.SYSTEM_CACHE_NAME + offset.toString();
        return $('#cacheSection').data(key);
    },

    saveCache: function (offset, data) {
        var key = MessageBoard.SYSTEM_CACHE_NAME + offset.toString();
        $('#cacheSection').data(key, data);
    },

    processPagination: function (data) {
        var htmlMessageBoard = data.result;
        $('#messageBoard').html(htmlMessageBoard);

        /**
         * 每次加载都先隐藏分页链接，根据 JSON 返回值判断是否显示上一页或者下一页链接
         */
        $('.pager li').hide();

        if (data.prev.hasPrev != "") {
            $('#pagePrev').show().data('offset', data.prev.offset);
        }

        if (data.next.hasNext != "") {
            $('#pageNext').show().data('offset', data.next.offset);
        }
    },

    loadMessage: function (offset) {
        var cache = MessageBoard.loadCache(offset);
        if (cache == undefined) {
            $.get('scripts/listMessage.php', {offset: offset}, function (data) {
                $.cookie('globalOffset', offset);
                MessageBoard.processPagination(data);
                MessageBoard.saveCache(offset, data);
            }, 'json');
        } else {
            MessageBoard.processPagination(cache);
        }
    },

    postMessage: function (postData) {
        $.post('scripts/postMessage.php', postData, function (data) {
            var htmlMessageItem = data.result;
            $('#messageBoard').prepend(htmlMessageItem);

            $('#btnReset').click();

            noty({
                text: MessageBoard.SYSTEM_MESSAGE_POST_SUCCEED,
                type: MessageBoard.SYSTEM_NOTY_SUCCESS,
                layout: MessageBoard.SYSTEM_LAYOUT_TOP_CENTER,
                timeout: MessageBoard.SYSTEM_NOTY_TIMEOUT
            });
        }, 'json');
    },

    scrollToTop: function () {
        $('html, body').animate({
            scrollTop: $('.jumbotron').offset().top
        }, 1000);
    },

    clearCache: function () {
        noty({
            text: MessageBoard.SYSTEM_MESSAGE_CLEAR_CACHE_CONFIRM,
            layout: MessageBoard.SYSTEM_LAYOUT_CENTER,
            modal: true,
            buttons: [
                {
                    addClass: 'btn btn-primary',
                    text: '确定',
                    onClick: function ($noty) {
                        $noty.close();
                        $.get('scripts/cache.php', {clearcache: 1}, function (data) {
                            if (data.cache_cleared) {
                                window.location.reload();
                            }
                        }, 'json');
                    }
                },
                {
                    addClass: 'btn btn-danger',
                    text: '取消',
                    onClick: function ($noty) {
                        $noty.close();
                    }
                }
            ]
        });
    }
};

MessageBoard.init();

/**
 * 留言板主要功能
 */
$(function () {
    /**
     * 清除缓存
     */
    $('#btnClearCache').click(function () {
        MessageBoard.clearCache();
        return false;
    });
    /**
     * 提交留言
     */
    $('#btnSubmit').click(function () {
        if (LoginManager.isLogin()) {
            /**
             * 留言板标题和内容非空验证
             */
            var $title = $.trim($('#ArticleTitle').val());
            var $content = $.trim($('#ArticleContent').val());

            if ($title == '') {
                noty({
                    text: MessageBoard.SYSTEM_MESSAGE_TITLE_REQUIRED,
                    type: MessageBoard.SYSTEM_NOTY_WARNING,
                    layout: MessageBoard.SYSTEM_LAYOUT_TOP_CENTER,
                    timeout: MessageBoard.SYSTEM_NOTY_TIMEOUT
                });
                return false;
            }

            if ($content == '') {
                noty({
                    text: MessageBoard.SYSTEM_MESSAGE_CONTENT_REQUIRED,
                    type: MessageBoard.SYSTEM_NOTY_WARNING,
                    layout: MessageBoard.SYSTEM_LAYOUT_TOP_CENTER,
                    timeout: MessageBoard.SYSTEM_NOTY_TIMEOUT
                });
                return false;
            }

            MessageBoard.postMessage({
                title: $title,
                content: $content,
                uid: $('#login_qq_span').html(),
                nickname: $('#login_nickname_span').html()
            });

        } else {
            noty({
                text: MessageBoard.SYSTEM_MESSAGE_LOGIN_REQUIRED,
                type: MessageBoard.SYSTEM_NOTY_ERROR,
                layout: MessageBoard.SYSTEM_LAYOUT_TOP_CENTER,
                timeout: MessageBoard.SYSTEM_NOTY_TIMEOUT
            });
        }
        return false;
    });

    /**
     * 翻页链接，上一页下一页
     */
    $('.pager a, .pagination a').click(function () {
        var $li = $(this).parent('li');
        MessageBoard.loadMessage($li.data('offset'));
        MessageBoard.scrollToTop();
        return false;
    });

    /**
     * 初次访问页面，加载留言板，HTML Cache
     */
    if ($.cookie('globalOffset')) {
        globalOffset = $.cookie('globalOffset');
    }
    MessageBoard.loadMessage(globalOffset);
});