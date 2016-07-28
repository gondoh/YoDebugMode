<?php
class YoDebugModeControllerEventListener extends BcControllerEventListener {
/**
 * 登録イベント
 *
 * @var array
 */
	public $events = array(
		'startup',
	);

	/**
	 * デバッグモードの変更が設定されていたら、変更するよ
	 * @param CakeEvent $event
	 */
	public function startup(CakeEvent $event) {
		$Controller = $event->subject();
		
		// 有効性チェック
		// 設定済みチェック
		if ($Controller->siteConfigs[Configure::read('YoDebugMode.statusKeyName')] &&
			($Controller->siteConfigs[Configure::read('YoDebugMode.ipAddrKeyName')] || 
				$Controller->siteConfigs[Configure::read('YoDebugMode.loingUserKeyName')])) {
			
			$ipLimit = $Controller->siteConfigs[Configure::read('YoDebugMode.ipAddrKeyName')];
			$userLimit = $Controller->siteConfigs[Configure::read('YoDebugMode.loingUserKeyName')];
			
			// IP妥当性チェック
			if (!empty($ipLimit)) {
				if (empty($_SERVER['REMOTE_ADDR'])) return;
				$remoteAddr = $_SERVER['REMOTE_ADDR'];
				// IPv6
				if (filter_var($remoteAddr, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
					// フォーマット合わせ
					$remoteAddr = inet_ntop(inet_pton($remoteAddr));
					$ipLimit = inet_ntop(inet_pton($ipLimit));
					if (strpos($remoteAddr, $ipLimit) === false) {
						return;
					}

				// IPv4
				} else {
					if (strpos($remoteAddr, $ipLimit) === false) {
						return;
					}
				}
			}
			
			// ユーザ妥当性チェック
			if (!empty($userLimit)) {
				if (empty($_SESSION['Auth']['User']['id'])) return;
				if ($userLimit !== $_SESSION['Auth']['User']['id']) return;
			}
			
			// 実行
			$mode = intval($Controller->siteConfigs[Configure::read('YoDebugMode.modeKeyName')]);
			Configure::write('debug', $mode);
			// DboSouceのfulldebug書き換え
			$dbConfig = new DATABASE_CONFIG();
			if (isset($dbConfig->baser)) {
				$con = ConnectionManager::getDataSource("baser");
				$con->fullDebug = Configure::read('debug') > 1;
			}
			if (isset($dbConfig->plugin)) {
				$con = ConnectionManager::getDataSource("plugin");
				$con->fullDebug = Configure::read('debug') > 1;
			}
			if (isset($dbConfig->test)) {
				$con = ConnectionManager::getDataSource("test");
				$con->fullDebug = Configure::read('debug') > 1;
			}
		}
	}
}
