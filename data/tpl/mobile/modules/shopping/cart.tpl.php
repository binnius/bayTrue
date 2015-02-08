<?php defined('IN_IA') or exit('Access Denied');?><?php  $bootstrap_type = 3;?>
<?php  include $this->template('header', TEMPLATE_INCLUDEPATH);?>
<link type="text/css" rel="stylesheet" href="./source/modules/shopping/images/style.css">
<style>
body{padding-bottom:85px;}
</style>
<div class="head">
	<a href="javascript:history.go(-1);" class="bn pull-left"><i class="icon-angle-left"></i></a>
	<span class="title">购物车</span>
	<a href="<?php  echo $this->createMobileUrl('clear');?>" onclick="return confirm('此操作不可恢复，确认？'); return false;" class="bn pull-right" style="font-size:18px;"><i class="icon-trash"></i> 清空</a>
</div>
<div class="shopcart-main img-rounded">
	<div class="shopcart-hd">
		<span class="pull-left"><?php  if(empty($_W['account']['name'])) { ?>微擎团队<?php  } else { ?><?php  echo $_W['account']['name'];?><?php  } ?>»</span>
		<a class="pull-right icon-remove-sign" href="<?php  echo $this->createMobileUrl('clear');?>" onclick="return confirm('此操作不可恢复，确认？'); return false;"></a>
	</div>
	<?php  if(is_array($goods)) { foreach($goods as $item) { ?>
	<?php  $price +=  $item['marketprice'] * $cart['goods'][$item['id']]['total'];?>
	<div class="shopcart-item">
		<img src="<?php  echo $_W['attachurl'];?><?php  echo $item['thumb'];?>">
		<div class="shopcart-item-detail">
			<div class="name"><?php  echo $item['title'];?><?php  if($item['unit']) { ?><?php  } ?></div>
			<div class="price">单价：<?php  echo $item['marketprice'];?> 元<?php  if(!empty($item['unit'])) { ?> / <?php  echo $item['unit'];?><?php  } ?></div>
			<div class="price">小计：<span id="goodsprice_<?php  echo $item['id'];?>"><?php  echo $item['marketprice'] * $cart['goods'][$item['id']]['total']?></span> 元</div>
			<div class="input-group">
				<span class="input-group-btn">
					<button class="btn btn-default btn-sm" type="button" onclick="order.reduce(<?php  echo $item['id'];?>)"><i class="icon-minus"></i></button>
				</span>
				<input type="text" class="form-control input-sm pricetotal" style="border-left:0;" value="<?php  echo $cart['goods'][$item['id']]['total'];?>" price="<?php  echo $item['marketprice'];?>" pricetotal="<?php  echo $item['marketprice'] * $cart['goods'][$item['id']]['total']?>" id="goodsnum_<?php  echo $item['id'];?>" />
				<span class="input-group-btn">
					<button class="btn btn-default btn-sm" type="button" onclick="order.add(<?php  echo $item['id'];?>)"><i class="icon-plus"></i></button>
				</span>
			</div>
		</div>
		<a href="javascript:;" onclick="if (confirm('您确定要删除此商品吗？')) {ajaxopen('<?php  echo $this->createMobileUrl('deletecartgoods', array('id' => $item['id']))?>', function(){location.reload();});}return false;" class="shopcart-item-remove"><i class="icon-remove"></i> 删除</a>
	</div>
	<?php  } } ?>
</div>

<div class="shopcart-footer">
	<span class="pull-left">合计：<span id="pricetotal"><?php  echo $price;?></span></span>
	<a href="<?php  echo $this->createMobileUrl('confirm')?>" class="btn btn-success pull-right">立即结算</a>
</div>
</div>
<script type="text/javascript">
<!--
	var order = {
		'add' : function(goodsid) {
			var $this = this;
			$this.cart(goodsid, 'add');
		},
		'reduce' : function(goodsid) {
			var $this = this;
			
			if ($('#goodsnum_'+goodsid).val() == 1) {
				if (!confirm('确定要删除此商品吗？')) {
					return false;
				}
			}
			$this.cart(goodsid, 'reduce');
		},
		'cart' : function(goodsid, operation) {
			if (!goodsid) {
				alert('请选择商品！');
				return;
			}
			operation = operation ? operation : 'add';
			var total = 0;
			$.getJSON('<?php  echo $this->createMobileUrl('updatecart');?>', {'op' : operation, 'goodsid' : goodsid}, function(s){
				if (s.message.status) {
					$('#goodsnum_'+goodsid).val(s.message.total);
					$('#goodsnum_'+goodsid).attr('pricetotal', s.message.total * (parseInt(parseFloat($('#goodsnum_'+goodsid).attr('price')) * 1000)) / 1000);
					$('#goodsprice_'+goodsid).html($('#goodsnum_'+goodsid).attr('pricetotal'));
					$('.pricetotal').each(function(){
						total += parseInt(parseFloat($(this).attr('pricetotal')) * 1000);
					});
					$('#pricetotal').html(total / 1000);
					if (s.message.total == 0) {
						$('#goodsnum_'+goodsid).parent().parent().parent().remove();
					}
				} else {
					alert(s.message.message);
				}
			});
		}
	};
//-->
</script>
<?php  include $this->template('footerbar', TEMPLATE_INCLUDEPATH);?>