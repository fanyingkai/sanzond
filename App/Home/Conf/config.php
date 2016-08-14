<?php
define('DEFAULT_THEM', 'default');
return array(
	//数据库配置
    'DB_TYPE'   => 'sqlsrv', // 数据库类型
    'DB_HOST'   => '127.0.0.1', // 服务器地址
    'DB_NAME'   => 'test', // 数据库名
    'DB_USER'   => 'sa', // 用户名
    'DB_PWD'    => 'im123654im', // 密码
    'DB_PORT'   => 1433, // 端口
    //'DB_PARAMS' =>  array(), // 数据库连接参数
    'DB_PREFIX' => 'wy_', // 数据库表前缀
    'DB_CHARSET'=> 'utf8', // 字符集
    'DB_DEBUG'  =>  TRUE, // 数据库调试模式 开启后可以记录SQL日志
    'SHOW_PAGE_TRACE' =>true, //调试模式
    'LANG_SWITCH_ON'    => true,
    'DEFAULT_LANG'        => 'zh-cn',
    //主题配置
    'DEFAULT_THEME' => 'default',
    'TMPL_PARSE_STRING'  =>array(
        '__PUBLIC__' => '/Public/Static/Home/', // 更改默认的/Public 替换规则
        //'__JS__'     => '/Public/JS/', // 增加新的JS类库路径替换规则
        //'__UPLOAD__' => '/Uploads', // 增加新的上传路径替换规则 
    ),
    //标签库配置
    'TAGLIB_LOAD' => true, //加载标签库打开
    'TAGLIB_BUILD_IN' => 'Cx,TagLib\ymctm',
    'TAGLIB_PRE_LOAD' => 'TagLib\ymctm',// 预先加载标签
    'TAGLIB_BUILD_IN' => 'cx,TagLib\ymctm',// 定义成内置标签
);