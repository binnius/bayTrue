<?php
/**
 * 购物车
 *
 * @author 超级无聊
 * @url
 */
	$cart=pdo_fetchall("SELECT goodsid,total FROM ".tablename('shopping3_cart')." WHERE from_user = :from_user AND weid = '{$weid}' ", array(':from_user' => $from),'goodsid');
	foreach($likearr as $k=>$v){
		if(empty($v['title'])){
			unset($likearr[$k]);
		}
	}
	include $this->template('wl_mylike');
	