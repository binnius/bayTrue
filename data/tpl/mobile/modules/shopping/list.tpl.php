<?php defined('IN_IA') or exit('Access Denied');?><?php  $bootstrap_type = 3;?>
<?php  if(empty($_W['isajax'])) { ?>
<?php  include $this->template('header', TEMPLATE_INCLUDEPATH);?>
<link type="text/css" rel="stylesheet" href="./source/modules/shopping/images/style.css">
<div class="head">
	<a href="javascript:;" onclick="$('.head .order').toggleClass('hide');" class="bn pull-left"><i class="icon-reorder"></i></a>
	<span class="title">商城首页</span>
	<a href="<?php  echo $this->createMobileUrl('mycart')?>" class="bn pull-right"><i class="icon-shopping-cart"></i><span class="buy-num img-circle" id="carttotal"><?php  echo $carttotal;?></span></a>
	<ul class="unstyled order hide">
		<?php  if(is_array($category)) { foreach($category as $item) { ?>
		<li>
			<a href="<?php  echo $this->createMobileUrl('list', array('pcate' => $item['id']))?>" class="bigtype"><i class="icon-folder-open-alt"></i> <?php  echo $item['name'];?></a>
			<?php  if(is_array($children[$item['id']])) { foreach($children[$item['id']] as $child) { ?>
			<a href="<?php  echo $this->createMobileUrl('list', array('ccate' => $child['id']))?>" class="smtype"><i class="icon-folder-open-alt"></i> <?php  echo $child['name'];?></a>
			<?php  } } ?>
		</li>
		<?php  } } ?>
	</ul>
</div>

<div class="shopping-main">
	<form action="mobile.php" method="get">
		<input type="hidden" name="act" value="<?php  echo $_GPC['act'];?>" />
		<input type="hidden" name="eid" value="<?php  echo $_GPC['eid'];?>" />
		<input type="hidden" name="name" value="<?php  echo $_GPC['name'];?>" />
		<input type="hidden" name="do" value="<?php  echo $_GPC['do'];?>" />
		<input type="hidden" name="weid" value="<?php  echo $_GPC['weid'];?>" />
		<div class="input-group">
			<input type="text" class="form-control input-lg" name="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入商品关键字">
			<span class="input-group-btn">
				<button class="btn btn-danger btn-lg" type="submit">搜索</button>
			</span>
		</div>
	</form>
	<div class="list" id="list">
		<div class="list-tips">全部商品 (按销量) - 共<b><?php  echo $total;?></b>种</div>
<?php  } ?>
<?php  if(is_array($list)) { foreach($list as $item) { ?>
<div class="list-item img-rounded">
	<div>
		<a href="<?php  echo $this->createMobileUrl('detail', array('id' => $item['id']))?>"><img src="<?php  echo $_W['attachurl'];?><?php  echo $item['thumb'];?>"></a>
		<span class="title"><a href="<?php  echo $this->createMobileUrl('detail', array('id' => $item['id']))?>"><?php  echo $item['title'];?></a><?php  if($item['type'] == '2') { ?>(虚拟)<?php  } ?></span>
		<span><?php  echo $item['description'];?></span>
	</div>
	<span class="sold">
		<span class="soldnum pull-left">已售<?php  echo $item['sales'];?>件</span>
		<span class="price pull-right"><?php  echo $item['marketprice'];?>元 <?php  if($item['unit']) { ?> / <?php  echo $item['unit'];?><?php  } ?></span>
	</span>
	<div class="add-cart" onclick="order.add(<?php  echo $item['id'];?>)"><i class="icon-shopping-cart"></i> 添加到购物车</div>
</div>
<?php  } } ?>
<?php  if(empty($_W['isajax'])) { ?>
	</div>
	<div class="show-more"><a href="javascript:;" onclick="loadPage('<?php  echo $pindex;?>', 'list')" class="img-rounded" id="pager">浏览更多商品</a></div>
</div>
<script type="text/javascript">
<!--
	function loadPage(pindex, container) {
		pindex = parseInt(pindex) + 1;
		$.get(location.href, {'page' : pindex}, function(html){
			if (html.indexOf('list-item') > -1) {
				$('#'+container).append(html);
				$('#pager').get(0).onclick = function(){
					loadPage(pindex, container);
				}
			} else {
				$('#pager').html('已经显示全部商品');
			}
		});
	}

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
//-->
</script>
<?php  $footer_off = 1;?>
<?php  include $this->template('footer', TEMPLATE_INCLUDEPATH);?>
<?php  include $this->template('footerbar', TEMPLATE_INCLUDEPATH);?>
<?php  } ?>