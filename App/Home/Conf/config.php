<?php
define('DEFAULT_THEM', 'default');
return array(
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