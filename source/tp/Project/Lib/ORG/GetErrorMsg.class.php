<?php

class GetErrorMsg
{
    static public function wx_error_msg($code)
    {
        if ($code == -1) {
            return '微信平台系统繁忙';
        }

        $error_codes = array(40001 => '获取access_token时AppSecret错误，或者access_token无效', 40002 => '不合法的凭证类型', 40003 => '不合法的OpenID', 40004 => '不合法的媒体文件类型', 40005 => '不合法的文件类型', 40006 => '不合法的文件大小', 40007 => '不合法的媒体文件id', 40008 => '不合法的消息类型', 40009 => '不合法的图片文件大小', 40010 => '不合法的语音文件大小', 40011 => '不合法的视频文件大小', 40012 => '不合法的缩略图文件大小', 40013 => '不合法的APPID', 40014 => '不合法的access_token', 40015 => '不合法的菜单类型', 40016 => '不合法的按钮个数', 40017 => '不合法的按钮个数', 40018 => '不合法的按钮名字长度', 40019 => '不合法的按钮KEY长度', 40020 => '不合法的按钮URL长度', 40021 => '不合法的菜单版本号', 40022 => '不合法的子菜单级数', 40023 => '不合法的子菜单按钮个数', 40024 => '不合法的子菜单按钮类型', 40025 => '不合法的子菜单按钮名字长度', 40026 => '不合法的子菜单按钮KEY长度', 40027 => '不合法的子菜单按钮URL长度', 40028 => '不合法的自定义菜单使用用户', 40029 => '不合法的oauth_code', 40030 => '不合法的refresh_token', 40031 => '不合法的openid列表', 40032 => '不合法的openid列表长度', 40033 => '不合法的请求字符，不能包含\\uxxxx格式的字符', 40035 => '不合法的参数', 40038 => '不合法的请求格式', 40039 => '不合法的URL长度', 40050 => '不合法的分组id', 40051 => '分组名字不合法', 41001 => '缺少access_token参数', 41002 => '缺少appid参数', 41003 => '缺少refresh_token参数', 41004 => '缺少secret参数', 41005 => '缺少多媒体文件数据', 41006 => '缺少media_id参数', 41007 => '缺少子菜单数据', 41008 => '缺少oauth code', 41009 => '缺少openid', 42001 => 'access_token超时', 42002 => 'refresh_token超时', 42003 => 'oauth_code超时', 43001 => '需要GET请求', 43002 => '需要POST请求', 43003 => '需要HTTPS请求', 43004 => '需要接收者关注', 43005 => '需要好友关系', 44001 => '多媒体文件为空', 44002 => 'POST的数据包为空', 44003 => '图文消息内容为空', 44004 => '文本消息内容为空', 45001 => '多媒体文件大小超过限制', 45002 => '消息内容超过限制', 45003 => '标题字段超过限制', 45004 => '描述字段超过限制', 45005 => '链接字段超过限制', 45006 => '图片链接字段超过限制', 45007 => '语音播放时间超过限制', 45008 => '图文消息超过限制', 45009 => '接口调用超过限制', 45010 => '创建菜单个数超过限制', 45015 => '回复时间超过限制', 45016 => '系统分组，不允许修改', 45017 => '分组名字过长', 45018 => '分组数量超过上限', 46001 => '不存在媒体数据', 46002 => '不存在的菜单版本', 46003 => '不存在的菜单数据', 46004 => '不存在的用户', 47001 => '解析JSON/XML内容错误', 48001 => 'api功能未授权', 50001 => '用户未授权该api');

        if (isset($error_codes[$code])) {
            return $error_codes[$code];
        } else {
            return '错误号：' . $code . ',未知错误';
        }
    }

    static public function qiyeErrorCode($code)
    {
        if ($code == -1) {
            return '微信平台系统繁忙';
        }

        $error_codes = array(-1 => '系统繁忙', 0 => '请求成功', 40001 => '获取access_token时AppSecret错误，或者access_token无效', 40002 => '不合法的凭证类型', 40003 => '不合法的UserID', 40004 => '不合法的媒体文件类型', 40005 => '不合法的文件类型', 40006 => '不合法的文件大小', 40007 => '不合法的媒体文件id', 40008 => '不合法的消息类型', 40013 => '不合法的corpid', 40014 => '不合法的access_token', 40015 => '不合法的菜单类型', 40016 => '不合法的按钮个数', 40017 => '不合法的按钮类型', 40018 => '不合法的按钮名字长度', 40019 => '不合法的按钮KEY长度', 40020 => '不合法的按钮URL长度', 40021 => '不合法的菜单版本号', 40022 => '不合法的子菜单级数', 40023 => '不合法的子菜单按钮个数', 40024 => '不合法的子菜单按钮类型', 40025 => '不合法的子菜单按钮名字长度', 40026 => '不合法的子菜单按钮KEY长度', 40027 => '不合法的子菜单按钮URL长度', 40028 => '不合法的自定义菜单使用员工', 40029 => '不合法的oauth_code', 40031 => '不合法的UserID列表', 40032 => '不合法的UserID列表长度', 40033 => '不合法的请求字符，不能包含\\uxxxx格式的字符', 40035 => '不合法的参数', 40038 => '不合法的请求格式', 40039 => '不合法的URL长度', 40040 => '不合法的插件token', 40041 => '不合法的插件id', 40042 => '不合法的插件会话', 40048 => 'url中包含不合法domain', 40054 => '不合法的子菜单url域名', 40055 => '不合法的按钮url域名', 40056 => '不合法的agentid', 40057 => '不合法的callbackurl', 40058 => '不合法的红包参数', 40059 => '不合法的上报地理位置标志位', 40060 => '设置上报地理位置标志位时没有设置callbackurl', 40061 => '设置应用头像失败', 40062 => '不合法的应用模式', 40063 => '红包参数为空', 40064 => '管理组名字已存在', 40065 => '不合法的管理组名字长度', 40066 => '不合法的部门列表', 40067 => '标题长度不合法', 40068 => '不合法的标签ID', 40069 => '不合法的标签ID列表', 40070 => '列表中所有标签（用户）ID都不合法', 40071 => '不合法的标签名字，标签名字已经存在', 40072 => '不合法的标签名字长度', 40073 => '不合法的openid', 40074 => 'news消息不支持指定为高保密消息', 41001 => '缺少access_token参数', 41002 => '缺少corpid参数', 41003 => '缺少refresh_token参数', 41004 => '缺少secret参数', 41005 => '缺少多媒体文件数据', 41006 => '缺少media_id参数', 41007 => '缺少子菜单数据', 41008 => '缺少oauth code', 41009 => '缺少UserID', 41010 => '缺少url', 41011 => '缺少agentid', 41012 => '缺少应用头像mediaid', 41013 => '缺少应用名字', 41014 => '缺少应用描述', 41015 => '缺少Content', 41016 => '缺少标题', 41017 => '缺少标签ID', 41018 => '缺少标签名字', 42001 => 'access_token超时', 42002 => 'refresh_token超时', 42003 => 'oauth_code超时', 42004 => '插件token超时', 43001 => '需要GET请求', 43002 => '需要POST请求', 43003 => '需要HTTPS', 43004 => '需要接收者关注', 43005 => '需要好友关系', 43006 => '需要订阅', 43007 => '需要授权', 43008 => '需要支付授权', 43009 => '需要认证', 43010 => '需要处于企业模式', 43011 => '需要企业授权', 44001 => '多媒体文件为空', 44002 => 'POST的数据包为空', 44003 => '图文消息内容为空', 44004 => '文本消息内容为空', 45001 => '多媒体文件大小超过限制', 45002 => '消息内容超过限制', 45003 => '标题字段超过限制', 45004 => '描述字段超过限制', 45005 => '链接字段超过限制', 45006 => '图片链接字段超过限制', 45007 => '语音播放时间超过限制', 45008 => '图文消息超过限制', 45009 => '接口调用超过限制', 45010 => '创建菜单个数超过限制', 45015 => '回复时间超过限制', 45016 => '系统分组，不允许修改', 45017 => '分组名字过长', 45018 => '分组数量超过上限', 46001 => '不存在媒体数据', 46002 => '不存在的菜单版本', 46003 => '不存在的菜单数据', 46004 => '不存在的员工', 47001 => '解析JSON/XML内容错误', 48002 => 'Api禁用', 50001 => 'redirect_uri未授权', 50002 => '员工不在权限范围', 50003 => '应用已停用', 50004 => '员工状态不正确（未关注状态）', 50005 => '企业已禁用', 60001 => '部门长度不符合限制', 60002 => '部门层级深度超过限制', 60003 => '部门不存在', 60004 => '父亲部门不存在', 60005 => '不允许删除有成员的部门', 60006 => '不允许删除有子部门的部门', 60007 => '不允许删除根部门', 60008 => '部门名称已存在', 60009 => '部门名称含有非法字符', 60010 => '部门存在循环关系', 60011 => '管理员权限不足，（user/department/agent）无权限', 60012 => '不允许删除默认应用', 60013 => '不允许关闭应用', 60014 => '不允许开启应用', 60015 => '不允许修改默认应用可见范围', 60016 => '不允许删除存在成员的标签', 60017 => '不允许设置企业', 60102 => 'UserID已存在', 60103 => '手机号码不合法', 60104 => '手机号码已存在', 60105 => '邮箱不合法', 60106 => '邮箱已存在', 60107 => '微信号不合法', 60108 => '微信号已存在', 60109 => 'QQ号已存在', 60110 => '部门个数超出限制', 60111 => 'UserID不存在', 60112 => '成员姓名不合法', 60113 => '身份认证信息（微信号/手机/邮箱）不能同时为空', 60114 => '性别不合法');

        if (isset($error_codes[$code])) {
            return $error_codes[$code];
        } else {
            return '错误号：' . $code . ',未知错误';
        }
    }

    static public function cUrl_error_msg($code)
    {
        $error_codes = array(1 => 'CURLE_UNSUPPORTED_PROTOCOL', 2 => 'CURLE_FAILED_INIT', 3 => 'CURLE_URL_MALFORMAT', 4 => 'CURLE_URL_MALFORMAT_USER', 5 => 'CURLE_COULDNT_RESOLVE_PROXY', 6 => 'CURLE_COULDNT_RESOLVE_HOST', 7 => 'CURLE_COULDNT_CONNECT', 8 => 'CURLE_FTP_WEIRD_SERVER_REPLY', 9 => 'CURLE_REMOTE_ACCESS_DENIED', 11 => 'CURLE_FTP_WEIRD_PASS_REPLY', 13 => 'CURLE_FTP_WEIRD_PASV_REPLY', 14 => 'CURLE_FTP_WEIRD_227_FORMAT', 15 => 'CURLE_FTP_CANT_GET_HOST', 17 => 'CURLE_FTP_COULDNT_SET_TYPE', 18 => 'CURLE_PARTIAL_FILE', 19 => 'CURLE_FTP_COULDNT_RETR_FILE', 21 => 'CURLE_QUOTE_ERROR', 22 => 'CURLE_HTTP_RETURNED_ERROR', 23 => 'CURLE_WRITE_ERROR', 25 => 'CURLE_UPLOAD_FAILED', 26 => 'CURLE_READ_ERROR', 27 => 'CURLE_OUT_OF_MEMORY', 28 => 'CURLE_OPERATION_TIMEDOUT', 30 => 'CURLE_FTP_PORT_FAILED', 31 => 'CURLE_FTP_COULDNT_USE_REST', 33 => 'CURLE_RANGE_ERROR', 34 => 'CURLE_HTTP_POST_ERROR', 35 => 'CURLE_SSL_CONNECT_ERROR', 36 => 'CURLE_BAD_DOWNLOAD_RESUME', 37 => 'CURLE_FILE_COULDNT_READ_FILE', 38 => 'CURLE_LDAP_CANNOT_BIND', 39 => 'CURLE_LDAP_SEARCH_FAILED', 41 => 'CURLE_FUNCTION_NOT_FOUND', 42 => 'CURLE_ABORTED_BY_CALLBACK', 43 => 'CURLE_BAD_FUNCTION_ARGUMENT', 45 => 'CURLE_INTERFACE_FAILED', 47 => 'CURLE_TOO_MANY_REDIRECTS', 48 => 'CURLE_UNKNOWN_TELNET_OPTION', 49 => 'CURLE_TELNET_OPTION_SYNTAX', 51 => 'CURLE_PEER_FAILED_VERIFICATION', 52 => 'CURLE_GOT_NOTHING', 53 => 'CURLE_SSL_ENGINE_NOTFOUND', 54 => 'CURLE_SSL_ENGINE_SETFAILED', 55 => 'CURLE_SEND_ERROR', 56 => 'CURLE_RECV_ERROR', 58 => 'CURLE_SSL_CERTPROBLEM', 59 => 'CURLE_SSL_CIPHER', 60 => 'CURLE_SSL_CACERT', 61 => 'CURLE_BAD_CONTENT_ENCODING', 62 => 'CURLE_LDAP_INVALID_URL', 63 => 'CURLE_FILESIZE_EXCEEDED', 64 => 'CURLE_USE_SSL_FAILED', 65 => 'CURLE_SEND_FAIL_REWIND', 66 => 'CURLE_SSL_ENGINE_INITFAILED', 67 => 'CURLE_LOGIN_DENIED', 68 => 'CURLE_TFTP_NOTFOUND', 69 => 'CURLE_TFTP_PERM', 70 => 'CURLE_REMOTE_DISK_FULL', 71 => 'CURLE_TFTP_ILLEGAL', 72 => 'CURLE_TFTP_UNKNOWNID', 73 => 'CURLE_REMOTE_FILE_EXISTS', 74 => 'CURLE_TFTP_NOSUCHUSER', 75 => 'CURLE_CONV_FAILED', 76 => 'CURLE_CONV_REQD', 77 => 'CURLE_SSL_CACERT_BADFILE', 78 => 'CURLE_REMOTE_FILE_NOT_FOUND', 79 => 'CURLE_SSH', 80 => 'CURLE_SSL_SHUTDOWN_FAILED', 81 => 'CURLE_AGAIN', 82 => 'CURLE_SSL_CRL_BADFILE', 83 => 'CURLE_SSL_ISSUER_ERROR', 84 => 'CURLE_FTP_PRET_FAILED', 84 => 'CURLE_FTP_PRET_FAILED', 85 => 'CURLE_RTSP_CSEQ_ERROR', 86 => 'CURLE_RTSP_SESSION_ERROR', 87 => 'CURLE_FTP_BAD_FILE_LIST', 88 => 'CURLE_CHUNK_FAILED');

        if (isset($error_codes[$code])) {
            return $error_codes[$code];
        } else {
            return '错误号：' . $code . ',未知错误';
        }
    }
}


?>