<?php
/**
 * 详情
 *
 * @author 超级无聊
 * @url
 */
	$goods = pdo_fetch("SELECT * FROM ".tablename('shopping3_goods')." WHERE weid={$weid} and  id = {$goodsid}");
	if (empty($goods)) {
		message('抱歉，商品不存在或是已经被删除！');
	}		
	
	include $this->template('wl_detail');