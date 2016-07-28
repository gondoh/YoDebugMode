<?php echo $this->BcForm->create('SiteConfig') ?>

<!-- form -->
<div class="section">
	<table cellpadding="0" cellspacing="0" class="form-table">
		<tr>
			<th class="col-head"><?php echo $this->BcForm->label(Configure::read('YoDebugMode.statusKeyName'), '有効状態') ?></th>
			<td class="col-input">
				<?php echo $this->BcForm->input(Configure::read('YoDebugMode.statusKeyName'), array('type' => 'checkbox', 'label' => '有効')) ?>
				<?php echo $this->BcForm->error(Configure::read('YoDebugMode.statusKeyName')) ?>
			</td>
		</tr>
		<tr>
			<th class="col-head"><?php echo $this->BcForm->label(Configure::read('YoDebugMode.modeKeyName'), '制作・開発モード') ?></th>
			<td class="col-input">
				<?php echo $this->BcForm->select(Configure::read('YoDebugMode.modeKeyName'), $modeList, array('empty' => false)) ?>
				<?php echo $this->BcForm->error(Configure::read('YoDebugMode.modeKeyName')) ?>
			</td>
		</tr>
		<tr>
			<th class="col-head"><?php echo $this->BcForm->label(Configure::read('YoDebugMode.ipAddrKeyName'), 'IPアドレスフィルタリング') ?></th>
			<td class="col-input">
				現在のアクセスIPアドレス&nbsp;&nbsp;<span style="color: red;"><?php echo $_SERVER['REMOTE_ADDR']; ?></span><br />
				<?php echo $this->BcForm->input(Configure::read('YoDebugMode.ipAddrKeyName'), array('type' => 'text', 'size' => 40, 'class' => 'full-width', 'placeholder' => '(192.168.0.1 | 192.168.0 | ::1 | 2001:0db8:bd05:01d2:288a:1fc0:0001:10ee)')) ?>
				<br /><small>IPv4、IPv6形式の指定が可能。下位ビットの指定を省略してネットワークアドレスでの指定が可能です</small>
				<?php echo $this->BcForm->error(Configure::read('YoDebugMode.ipAddrKeyName')) ?>
			</td>
		</tr>
		<tr>
			<th class="col-head"><?php echo $this->BcForm->label(Configure::read('YoDebugMode.loingUserKeyName'), 'ログインユーザフィルタリング') ?></th>
			<td class="col-input">
				<?php echo $this->BcForm->select(Configure::read('YoDebugMode.loingUserKeyName'), $userList, array('empty' => '-指定なし-')) ?>
				<?php echo $this->BcForm->error(Configure::read('YoDebugMode.loingUserKeyName')) ?>
			</td>
		</tr>
	</table>
</div>

<div class="submit">
	<?php echo $this->BcForm->button('保存', array('div' => false, 'class' => 'button', 'id' => 'BtnSave')) ?>
</div>

<?php echo $this->BcForm->end(); ?>
