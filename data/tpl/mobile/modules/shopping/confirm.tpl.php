<?php defined('IN_IA') or exit('Access Denied');?><?php  $bootstrap_type = 3;?>
<?php  include $this->template('header', TEMPLATE_INCLUDEPATH);?>
<link type="text/css" rel="stylesheet" href="./source/modules/shopping/images/style.css">
<div class="head">
	<a href="javascript:history.go(-1);" class="bn pull-left"><i class="icon-angle-left"></i></a>
	<span class="title">购物车</span>
	<a href="javascript:;" class="bn pull-right"><i class="icon-shopping-cart"></i><span class="buy-num img-circle"> <?php  echo $carttotal;?> </span></a>
</div>
<form class="form-horizontal" method="post" role="form">
<input type="hidden" name="goodstype" value="<?php  echo $goodstype;?>" />
<div class="order-main">
	<h5>收货地址</h5>
	<div id="myaddress">
	<?php  if(is_array($address)) { foreach($address as $row) { ?>
	<label class="address row" id="address_<?php  echo $row['id'];?>">
		<div class="col-xs-2"><input type="radio" name="address" id="myaddress_<?php  echo $row['id'];?>" <?php  if($row['isdefault']) { ?>checked<?php  } ?> value="<?php  echo $row['id'];?>"></div>
		<div class="detail col-xs-10">
			<span><?php  echo $row['province'];?> <?php  echo $row['city'];?> <?php  echo $row['area'];?> <?php  echo $row['address'];?> <?php  echo $row['realname'];?>, <?php  echo $row['mobile'];?></span>
			<span><a href="javascript:;" onclick="editAddress(<?php  echo $row['id'];?>)">修改地址</a>&nbsp;&nbsp;<a href="javascript:;" onclick="saveDefaultAddress(<?php  echo $row['id'];?>)">设置为默认收货地址</a></span>
		</div>
	</label>
	<?php  } } ?>
	</div>
	<div><button type="button" class="btn btn-danger" onclick="addAddress()"><i class="icon-plus"></i> 添加修改地址</button></div>
	<div class="add-address img-rounded" id="addAddressPanel" <?php  if(!empty($address)) { ?> style="display:none;"<?php  } ?>>
		<div class="add-address-hd">请填写新的收货地址：</div>
		<div class="add-address-main">
			<div class="form-group">
				<label for="" class="col-sm-3 control-label">收货人：</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="realname">
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-3 control-label">联系电话：</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="mobile">
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-3 control-label">地区：</label>
				<div class="col-sm-9">
					<select id="sel-provance" onChange="selectCity();" class="pull-left form-control" style="width:30%; margin-right:5%;">
						<option value="" selected="true">省/直辖市</option>
					</select>
					<select id="sel-city" onChange="selectcounty()" class="pull-left form-control" style="width:30%; margin-right:5%;">
						<option value="" selected="true">请选择</option>
					</select>
					<select id="sel-area" class="pull-left form-control" style="width:30%;">
						<option value="" selected="true">请选择</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-3 control-label">详细地址：</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="address">
				</div>
			</div>
			<input type="hidden" id="addressid" value="" />
			<div class="form-group">
				<div class="col-sm-12">
					<button type="button" class="btn btn-danger" onclick="saveAddress()">保存</button>
					<button type="button" class="btn" onclick="addAddress();$('#addAddressPanel').hide();$('#addressid').val('');">取消</button>
				</div>
			</div>
		</div>
	</div>
	<h5>订单详情</h5>
	<div class="order-detail">
		<table class="table">
			<thead>
				<tr>
					<th class="name">商品名称</th>
					<th class="num">商品数量</th>
					<th class="total">合计</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($goods)) { foreach($goods as $item) { ?>
				<?php  $price +=  $item['marketprice'] * $cart['goods'][$item['id']]['total'];?>
				<tr>
					<td class="name"><span><?php  echo $item['title'];?></span></td>
					<td class="num"><?php  echo $cart['goods'][$item['id']]['total'];?></td>
					<td class="total"><?php  echo $item['marketprice'] * $cart['goods'][$item['id']]['total']?> 元</td>
				</tr>
				<?php  } } ?>
			</tbody>
		</table>
		<div class="order-detail-hd"> <span class="pull-right" style="color:#E74C3C;">[总计：<?php  echo $price;?> 元]</span></div>
		<div style="clear:both;"></div>
	</div>
	<?php  if($cart['type'] == 1) { ?>
	<h5>配送方式</h5>
	<select name="sendtype" class="form-control">
		<option value="1">快递</option>
		<option value="2">自提</option>
	</select>
	<?php  } ?>
	<h5>留言</h5>
	<div class="message-box">
		<textarea class="form-control" rows="3" name="remark" placeholder="亲，还用什么能帮助到您吗？就写到这里吧！"></textarea>
	</div>
	<button type="submit" name="submit" value="yes" class="btn btn-success order-submit btn-lg">提交订单</button>
	<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
</div>
<script type="text/javascript" src="./resource/script/cascade.js"></script>
<script type="text/javascript">
cascdeInit('','','');
function saveAddress() {
	var realname = $('#realname').val();
	var mobile = $('#mobile').val();
	var province = $('#sel-provance').val();
	var city = $('#sel-city').val();
	var area = $('#sel-area').val();
	var address = $('#address').val();
	if (!realname) {
		alert('请输入您的真实姓名！');
		return false;
	}
	if (!mobile) {
		alert('请输入您的手机号码！');
		return false;
	}
	if (mobile.search(/^([0-9]{11})?$/) == -1) {
		alert('请输入正确的手机号码！');
		return false;
	}
	if (!address) {
		alert('请输入您的详细地址！');
		return false;
	}
	$.post('<?php  echo $this->createMobileUrl('address')?>', {
		'realname' : realname,
		'mobile' : mobile,
		'province' : province,
		'city' : city,
		'area' : area, 
		'address' : address,
		'id' : $('#addressid').val()
	}, function(s) {
		if (s.message != 0) {
			$("input [name='address']").attr('checked', false);
			var html = '<label class="address" id="address_'+s.message+'"><div><input type="radio" checked value="'+s.message+'" name="address" /></div>' +
						'<div class="detail">'+province+' '+city+' '+area+' '+''+address+' '+realname+', '+mobile+'<span></span>' +
						'<span><a href="#">修改地址</a>&nbsp;&nbsp;<a href="javascript:;" onclick="saveDefaultAddress('+s.message+')">设置为默认收货地址</a></span></div></label>';
			if ($('#address_'+s.message).get(0)) {
				$('#address_'+s.message).replaceWith($(html));
			} else {
				$('#myaddress').append($(html));
			}
			
			$('#realname').val('');
			$('#mobile').val('');
			$('#address').val('');
			cascdeInit('','','');
		}
		$('#addAddressPanel').hide();
	}, 'json');

}

function addAddress() {
	$('#addAddressPanel').show();
	$('#realname').val('');
	$('#mobile').val('');
	$('#address').val('');
	cascdeInit('','','');
	$('#addressid').val('');

}

function saveDefaultAddress(id) {
	$.post('<?php  echo $this->createMobileUrl('address', array('op' => 'default'))?>', {
		'id' : id,
	}, function(s) {
		$("input [name='address']").attr('checked', false);
		$("#myaddress_"+id).attr('checked', true);
	}, 'json');
}

function editAddress(id) {
	$.get('<?php  echo $this->createMobileUrl('address', array('op' => 'detail'))?>', {
		'id' : id,
	}, function(s){
		if (s.message) {
			$('#addAddressPanel').show();
			$('#realname').val(s.message.realname);
			$('#mobile').val(s.message.mobile);
			$('#address').val(s.message.address);
			cascdeInit(s.message.province,s.message.city,s.message.area);
			$('#addressid').val(s.message.id);
		}
	}, 'json');
}
</script>
<?php  include $this->template('footer', TEMPLATE_INCLUDEPATH);?>
<?php  include $this->template('footerbar', TEMPLATE_INCLUDEPATH);?>