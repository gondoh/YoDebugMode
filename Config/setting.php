<?php
$config = array(
	"YoDebugMode" => array(
		'statusKeyName' => 'YoDebugMode.status',
		'ipAddrKeyName' => 'YoDebugMode.ip',
		'loingUserKeyName' => 'YoDebugMode.user_id',
		'modeKeyName' => 'YoDebugMode.mode',
	),
	'BcApp.adminNavi.YoDebugMode' => array(
		'name'		 => 'YoDebugMode',
		'contents'	 => array(
			array('name'	 => '設定',
				'url'	 => array(
					'admin'		 => true,
					'plugin'	 => 'yo_debug_mode',
					'controller' => 'yo_debug_mode',
					'action'	 => 'index')
			)
		)
	)
);