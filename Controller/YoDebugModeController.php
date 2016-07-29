<?php
class YoDebugModeController extends BcPluginAppController {
	public $components = array('Cookie', 'BcAuth', 'BcAuthConfigure');
	public $uses = array("SiteConfig", "User");
	private $configName = null;
	
	public function admin_index(){
		$this->pageTitle = "デバッグモード限定設定 -YoDebugMode-";
		$statusKey = Configure::read('YoDebugMode.statusKeyName');
		$ipKey     = Configure::read('YoDebugMode.ipAddrKeyName');
		$userIdKey = Configure::read('YoDebugMode.loingUserKeyName');
		$modeIdKey = Configure::read('YoDebugMode.modeKeyName');
		$this->set("userList", $this->User->find("list", array(
			'fields' => array("id", "real_name_1")
		)));
		$modeList = $this->SiteConfig->getControlSource("mode");
		unset($modeList[-1]); // インストールモードは危険なので除外
		$this->set("modeList",$modeList);
		
		if (empty($this->request->data)) {
			
			$data = array(
				'YoDebugMode' => array(
					'status' => (empty($this->siteConfigs[$statusKey])) ? "" : $this->siteConfigs[$statusKey],
					'ip' => (empty($this->siteConfigs[$ipKey])) ? "" : $this->siteConfigs[$ipKey],
					'user_id' => (empty($this->siteConfigs[$userIdKey])) ? "" : $this->siteConfigs[$userIdKey],
					'mode' => (empty($this->siteConfigs[$modeIdKey])) ? "" : $this->siteConfigs[$modeIdKey],
				)
			);
		} else {
			foreach(array("status", "ip", "user_id", "mode") as $target) {
				// 更新
				if ($this->SiteConfig->findByName("YoDebugMode." . $target)) {
					// サニタイズ
					$db = $this->SiteConfig->getDataSource();
					$value = $db->value($this->request->data['YoDebugMode'][$target], 'string');
					// 更新実行
					$this->SiteConfig->updateAll(
						array('value' => $value),
						array('SiteConfig.name' => "YoDebugMode." . $target)
					);
				// 追加
				} else {
					$data = array(
						'name' => "YoDebugMode." . $target,
						'value' => $this->request->data['YoDebugMode'][$target]
					);
					$this->SiteConfig->create();
					$this->SiteConfig->save($data, false);
				}
			}
			$this->setMessage("更新しました", false);
			$this->redirect(array("action" => "index"));
		}
		$this->request->data = $data;
	}
}