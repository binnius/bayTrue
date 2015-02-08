<?php defined('IN_IA') or exit('Access Denied');?><?php  $bootstrap_type = 3;?>
<?php  include $this->template('header', TEMPLATE_INCLUDEPATH);?>
<link type="text/css" rel="stylesheet" href="./source/modules/shopping/images/style.css">
<div class="head">
	<a href="javascript:history.go(-1);" class="bn pull-left"><i class="icon-angle-left"></i></a>
	<span class="title"><?php  echo $goods['title'];?></span>
	<a href="<?php  echo $this->createMobileUrl('mycart')?>" class="bn pull-right"><i class="icon-shopping-cart"></i><span class="buy-num img-circle" id="carttotal"><?php  echo $carttotal;?></span></a>
</div>
<div class="detail-main">
	<div class="detail-img">
		<?php  if(!empty($goods['thumb'])) { ?><img class="img-rounded" src="<?php  echo $_W['attachurl'];?><?php  echo $goods['thumb'];?>" /><?php  } ?>
	</div>
	<div class="detail-div img-rounded">
		<div class="detail-group text-center" style="line-height:20px;"><?php  echo $goods['title'];?></div>
		<div class="detail-group">
			<span class="col-xs-4">价格</span>
			<span class="col-xs-8">
				¥ <span class="text-danger" style="font-size:18px; font-weight:bold;"><?php  echo $goods['marketprice'];?></span> / <?php  echo $goods['unit'];?>
			</span>
		</div>
		<a href="javascript:order.add(<?php  echo $goods['id'];?>);" class="btn btn-danger col-xs-12" style="margin-top:10px;"><i class="icon-plus"></i> 添加到购物车</a>
	</div>
	<div class="detail-div img-rounded other-detail">
		<?php  if($goods['total'] != -1) { ?>
		<div class="detail-group">
			<span class="col-xs-4">库存</span>
			<span class="col-xs-8"><?php  echo $goods['total'];?></span>
		</div>
		<?php  } ?>
		<?php  if(!empty($goods['goodssn'])) { ?>
		<div class="detail-group">
			<span class="col-xs-4">商品编号</span>
			<span class="col-xs-8"><?php  echo $goods['goodssn'];?></span>
		</div>
		<?php  } ?>
		<?php  if(!empty($goods['productsn'])) { ?>
		<div class="detail-group">
			<span class="col-xs-4">条形码</span>
			<span class="col-xs-8"><?php  echo $goods['productsn'];?></span>
		</div>
		<?php  } ?>
	</div>
	<div class="detail-div img-rounded detail-content">
		<?php  echo $goods['content'];?>
	</div>
</div>
<script>
$(function() {
	$('.other-detail .detail-group:last').css("border-bottom", "0");
});
var order = {
	'add' : function(goodsid) {
		var $this = this;
		$this.cart(goodsid, 'add');
	},
	'cart' : function(goodsid, operation) {
		if (!goodsid) {
			alert('请选择商品！');
			return;
		}
		operation = operation ? operation : 'add';
		$.getJSON('<?php  echo $this->createMobileUrl('updatecart');?>', {'op' : operation, 'goodsid' : goodsid}, function(s){
			if (s.message.status) {
				$('#carttotal').css({'width':'50px', 'height':'50px', 'line-height':'50px'}).html(s.message.carttotal).animate({'width':'20px', 'height':'20px', 'line-height':'20px'}, 'slow');
			} else {
				alert(s.message.message);
			}
		});
	}
};
</script>
<?php  $footer_off = 1;?>
<?php  include $this->template('footer', TEMPLATE_INCLUDEPATH);?>
<?php  include $this->template('footerbar', TEMPLATE_INCLUDEPATH);?>