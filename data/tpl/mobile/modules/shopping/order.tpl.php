<?php defined('IN_IA') or exit('Access Denied');?><?php  $bootstrap_type = 3;?>
<?php  include $this->template('header', TEMPLATE_INCLUDEPATH);?>
<link type="text/css" rel="stylesheet" href="./source/modules/shopping/images/style.css">
<div class="head">
	<a href="javascript:history.go(-1);" class="bn pull-left"><i class="icon-angle-left"></i></a>
	<span class="title">我的订单</span>
	<a href="<?php  echo $this->createMobileUrl('mycart')?>" class="bn pull-right"><i class="icon-shopping-cart"></i></a>
</div>
<?php  if(is_array($list)) { foreach($list as $item) { ?>
<div class="myoder img-rounded">
	<div class="myoder-hd">
		<span class="pull-left">订单编号：<?php  echo $item['ordersn'];?></span>
		<span class="pull-right"><?php  echo date('Y-m-d H:i', $item['createtime'])?></span>
	</div>
	<?php  if(is_array($item['goods'])) { foreach($item['goods'] as $goods) { ?>
	<div class="myoder-detail">
		<a href="<?php  echo $this->createMobileUrl('detail', array('id' => $goods['id']))?>"><img src="<?php  echo $_W['attachurl'];?><?php  echo $goods['thumb'];?>" width="160"></a>
		<div class="pull-left">
			<div class="name"><a href="<?php  echo $this->createMobileUrl('detail', array('id' => $goods['id']))?>"><?php  echo $goods['title'];?></a></div>
			<div class="price">
				<span><?php  echo $goods['marketprice'];?> 元<?php  if($goods['unit']) { ?> / <?php  echo $goods['unit'];?><?php  } ?></span>
				<span class="num"><?php  echo $item['total'][$goods['id']]['total'];?><?php  if($goods['unit']) { ?> <?php  echo $goods['unit'];?><?php  } ?></span>
			</div>
		</div>
	</div>
	<?php  } } ?>
	<?php  if($item['status'] == '2') { ?>
	<div class="myoder-express">
		<span class="express-company"><?php  echo $item['expresscom'];?></span>
		<span class="express-num"><?php  echo $item['expresssn'];?></span>
	</div>
	<?php  } ?>
	<div class="myoder-total">
		<span>共计：<span class="false"><?php  echo $item['price'];?> 元</span></span>
		<span>状态：
			<?php  if($item['paytype'] == 3) { ?>
				<?php  if($item['status'] == -1) { ?>
				<span class="text-muted">订单取消</span>
				<?php  } else if($item['status'] < 3) { ?>
				<span class="false">货到付款 / 未付款</span>
				<?php  } else { ?>
				<span class="text-success">已完成</span>
				<?php  } ?>
			<?php  } else { ?>
				<?php  if($item['status'] == -1) { ?>
				<span class="text-muted">订单取消</span>
				<?php  } else if($item['status'] == 0) { ?>
				<span class="false">未付款</span>
				<?php  } else if($item['status'] == 1) { ?>
				<span class="text-warning">已付款</span>
				<?php  } else if($item['status'] == 2) { ?>
				<span class="text-warning">已发货</span>
				<?php  } else { ?>
				<span class="text-success">已完成</span>
				<?php  } ?>
			<?php  } ?>
		</span>
		<?php  if($item['paytype'] != 3) { ?>
		<?php  if($item['status'] == 0) { ?>
		<a href="<?php  echo $this->createMobileUrl('pay', array('orderid' => $item['id']))?>" class="btn btn-danger pull-right btn-sm">立即支付</a>
		<?php  } ?>
		<?php  if($item['status'] == 2) { ?>
		<a href="<?php  echo $this->createMobileUrl('myorder', array('orderid' => $item['id'], 'operation' => 'confirm'))?>" class="btn btn-success pull-right btn-sm" onclick="confirm('点击确认收货前，请确认您的商品已经收到。确定收货吗？')">确认收货</a>
		<?php  } ?>
		<?php  } ?>
	</div>
</div>
<?php  } } ?>
<?php  include $this->template('footer', TEMPLATE_INCLUDEPATH);?>
<?php  include $this->template('footerbar', TEMPLATE_INCLUDEPATH);?>