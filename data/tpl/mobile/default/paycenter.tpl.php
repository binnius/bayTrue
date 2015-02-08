<?php defined('IN_IA') or exit('Access Denied');?><style>
body{background:#f2f2f2;}
.pay-detail{background:#0d95eb; padding:20px 10px; font-size:20px; color:#FFF;}
.pay-detail > div{overflow:hidden; margin-bottom:10px;}
.pay-detail .pull-left{color:#bad8f6;}
.pay-detail .ordernum{color:#fff44a;}

.pay-way{padding:10px; margin-bottom:20px; overflow:hidden;}
.pay-way > div{float:left; width:50%; padding:5px 0; border:1px #F2F2F2 solid; margin-bottom:10px; text-align:center; color:#999; cursor:pointer;}
.pay-way > div i{display:block; font-size:30px;}
.pay-way > div span{display:block; font-size:16px; margin-top:5px;}
.pay-way > div.active{border-color:#0d95eb; color:#0079ff;}

.pay-btn{padding:10px;}
.pay-btn .btn{width:100%; margin-bottom:10px;}
.pay-btn .btn-warning{background:#ffbf12; border-color:#eeab09;}
.pay-btn .btn-default{background:#FFF; border-color:#e5e5e5;}
</style>
<div class="pay-detail">
	<div>
		<span class="pull-left">订单号</span>
		<span class="pull-right ordernum"><?php  echo $params['ordersn'];?></span>
	</div>
	<div>
		<span class="pull-left">商家名称</span>
		<span class="pull-right"><?php  echo $params['title'];?></span>
	</div>
	<div>
		<span class="pull-left">支付金额</span>
		<span class="pull-right"><?php  echo sprintf('%.2f', $params['fee']);?><span class="muted"> 元</span></span>
	</div>
</div>
<div class="pay-way">
	<div id="cod">
		<i class="icon-truck"></i>
		<span>货到付款</span>
	</div>
	<?php  if(!empty($_W['account']['payment']['credit']['switch']) && !empty($_W['fans']['card'])) { ?>
	<div id="credit">
		<i class="icon-money"></i>
		<span>余额支付</span>
	</div>
	<?php  } ?>
	<?php  if(!empty($_W['account']['payment']['alipay']['switch'])) { ?>
	<div id="alipay">
		<i class="icon-credit-card"></i>
		<span>支付宝</span>
	</div>
	<?php  } ?>
	<?php  if(!empty($_W['account']['payment']['wechat']['switch'])) { ?>
	<div id="wechat">
		<i class="icon-credit-card"></i>
		<span>微信支付</span>
	</div>
	<?php  } ?>
	<?php  if(!empty($_W['account']['payment']['offline']['switch'])) { ?>
	<div id="offline">
		<i class="icon-credit-card"></i>
		<span>直接汇款</span>
	</div>
	<?php  } ?>
</div>
<div id="panel">
	<?php  if(!empty($_W['account']['payment']['alipay']['switch'])) { ?>
	<div class="pay-btn" id="alipay-panel" style="display:none;">
		<form action="<?php  echo create_url('mobile/cash/alipay', array('weid' => $_W['weid']));?>" method="post">
			<input type="hidden" name="params" value="<?php  echo base64_encode(json_encode($params));?>" />
			<button class="btn btn-warning btn-lg" type="submit" name="alipay">支付宝支付</button>
		</form>
	</div>
	<?php  } ?>
	<?php  if(!empty($_W['account']['payment']['wechat']['switch'])) { ?>
	<div class="pay-btn" id="wechat-panel" style="display:none;">
		<form action="<?php  echo create_url('mobile/cash/wechat', array('weid' => $_W['weid']));?>" method="post">
			<input type="hidden" name="params" value="<?php  echo base64_encode(json_encode($params));?>" />
			<button class="btn btn-warning btn-lg" disabled="disabled" type="submit" id="wBtn" value="wechat">微信支付(必须使用微信内置浏览器)</button>
		</form>
	</div>
	<script type="text/javascript">
		document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
			$('#wBtn').removeAttr('disabled');
			$('#wBtn').html('微信支付');
		});
	</script>
	<?php  } ?>

	<?php  if(!empty($_W['account']['payment']['credit']['switch']) && !empty($_W['fans']['card'])) { ?>
	<div class="pay-btn" id="credit-panel" style="display:none;">
		<form action="<?php  echo create_url('mobile/cash/credit2', array('weid' => $_W['weid']));?>" method="post">
			<input type="hidden" name="params" value="<?php  echo base64_encode(json_encode($params));?>" />
			<button class="btn btn-warning btn-lg" type="submit" value="credit">余额支付 （余额支付当前 <?php  echo sprintf('%.2f', $_W['fans']['credit2']);?>元)</button>
		</form>
	</div>
	<?php  } ?>
	<?php  if(empty($params['virtual'])) { ?>
	<div class="pay-btn" id="cod-panel" style="display:none;">
		<form action="" method="post">
		<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		<button type="submit" name="codsubmit" value="yes" class="btn btn-warning btn-lg">货到付款</button>
		</form>
	</div>
	<?php  } ?>
	<?php  if(!empty($_W['account']['payment']['offline']['switch'])) { ?>
	<div class="pay-btn" id="offline-panel" style="display:none;">
		<?php  echo htmlspecialchars_decode($_W['account']['payment']['offline']['account'])?>
	</div>
	<?php  } ?>
	<div class="pay-btn">
		<button type="button" disabled class="btn btn-warning btn-lg">请选择您的付款方式</button>
	</div>
</div>

<script type="text/javascript">
<!--
	$('.pay-way div').click(function(){
		$(this).attr('class', 'active').siblings().attr('class', '');
		$('#panel div').hide();
		$('#'+this.id+'-panel').show();
	});
//-->
</script>
