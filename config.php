<?php
$mainConf = array(
	'DB_TYPE'               => 'mysqli',     // 数据库类型
	'DB_HOST'               => '', // 服务器地址
	'DB_NAME'               => '', // 数据库名
	'DB_USER'               => '',      // 用户名
 	'DB_PWD'                => '',          // 密码
	'DB_PORT'               => 3306,        // 端口
	'DB_PREFIX'             => '',    // 数据库表前缀
	'DB_CHARSET'            => 'utf8mb4', // 数据库编码
	'DEFAULT_MODULE'        => 'Index', //默认模块
	'DB_DEBUG'              => TRUE, // 数据库调试模式 开启后可以记录SQL日志
	'URL_MODEL'             => '2', //URL模式
	'SESSION_AUTO_START'    => false, //是否开启session
	'URL_ROUTER_ON'         => true, // 开启路由
    'DEFAULT_CHARSET'        =>'utf-8', // 默认输出编码
    'DEFAULT_MODULE'        => 'Index', //默认模块
    'URL_MODEL'             => '2', //URL模式(rewrite 伪静态)
    'URL_ROUTER_ON'         => true, // 开启路由
    'DEFAULT_CHARSET'       =>'utf-8', // 默认输出编码
    'DATA_CACHE_TIME'       =>'1',
    'DEFAULT_TIMEZONE'=>'PRC'
  
     );
    return $mainConf;
?>