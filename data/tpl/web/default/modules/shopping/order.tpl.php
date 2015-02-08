<?php defined('IN_IA') or exit('Access Denied');?><?php  include $this->template('common/header', TEMPLATE_INCLUDEPATH);?>
<ul class="nav nav-tabs">
	<li <?php  if($operation == 'display' && $status == '1') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('order', array('op' => 'display', 'status' => 1))?>">待发货</a></li>
	<li <?php  if($operation == 'display' && $status == '0') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('order', array('op' => 'display', 'status' => 0))?>">待付款</a></li>
	<li <?php  if($operation == 'display' && $status == '2') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('order', array('op' => 'display', 'status' => 2))?>">待收货</a></li>
	<li <?php  if($operation == 'display' && $status == '-1') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('order', array('op' => 'display', 'status' => -1))?>">全部订单</a></li>
</ul>

<?php  if($operation == 'display') { ?>
<div class="main">
	<div style="padding:15px;">
		<table class="table table-hover">
			<thead class="navbar-inner">
				<tr>
					<th>订单号</th>
					<th style="width:100px;">姓名</th>
					<th style="width:80px;">电话</th>
					<th style="width:80px;">支付方式</th>
					<th style="width:80px;">配送方式</th>
					<th style="width:50px;">总价</th>
					<th style="width:50px;">类型</th>
					<th style="width:50px;">状态</th>
					<th style="width:150px;">下单时间</th>
					<th style="width:120px; text-align:right;">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
					<td><?php  echo $item['ordersn'];?></td>
					<td><?php  echo $address[$item['addressid']]['realname'];?></td>
					<td><?php  echo $address[$item['addressid']]['mobile'];?></td>
					<td><?php  if($item['paytype'] == 2) { ?><span class="label label-important">在线支付</span><?php  } ?><?php  if($item['paytype'] == 3) { ?><span class="label label-warning">货到付款</span><?php  } ?></td>
					<td><?php  if($item['goodstype']) { ?><?php  if($item['sendtype'] == 1) { ?><span class="label label-info">快递</span><?php  } else if($item['sendtype'] == 2) { ?><span class="label label-info">自提</span><?php  } ?><?php  } else { ?>无<?php  } ?></td>
					<td><?php  echo $item['price'];?> 元</td>
					<td><?php  if($item['goodstype']) { ?>实物<?php  } else { ?>虚拟<?php  } ?></td>
					<td>
						<?php  if($item['status'] == 0) { ?><span class="label label-info">待付款</span><?php  } ?>
						<?php  if($item['status'] == 1) { ?><span class="label label-info">待发货</span><?php  } ?>
						<?php  if($item['status'] == 2) { ?><span class="label label-info">待收货</span><?php  } ?>
						<?php  if($item['status'] == 3) { ?><span class="label label-success">已完成</span><?php  } ?>
						<?php  if($item['status'] == -1) { ?><span class="label label-success">已关闭</span><?php  } ?></td>
					<td><?php  echo date('Y-m-d H:i:s', $item['createtime'])?></td>
					<td style="text-align:right;"><a href="<?php  echo $this->createWebUrl('order', array('op' => 'detail', 'id' => $item['id']))?>">查看订单</a></td>
				</tr>
				<?php  } } ?>
			</tbody>
			<!--tr>
				<td></td>
				<td colspan="3">
					<input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
					<input type="submit" class="btn btn-primary" name="submit" value="提交" />
				</td>
			</tr-->
		</table>
		<?php  echo $pager;?>
	</div>
</div>
<?php  } else if($operation == 'detail') { ?>
<div class="main">
	<form class="form-horizontal form" action="" method="post" enctype="multipart/form-data" onsubmit="return formcheck(this)">
		<?php  if($item['transid']) { ?><div style="margin:10px 0; width:auto;" class="alert alert-error"><i class="icon-lightbulb"></i> 此为微信支付订单，必须要提交发货状态！</div><?php  } ?>
		<input type="hidden" name="id" value="<?php  echo $item['id'];?>">
		<h4>订单信息</h4>
		<table class="tb">
			<?php  if($item['transid']) { ?>
			<tr>
				<th><label for="">交易号</label></th>
				<td>
					<?php  echo $item['transid'];?>
				</td>
			</tr>
			<?php  } ?>
			<tr>
				<th><label for="">价钱</label></th>
				<td>
					<?php  echo $item['price'];?> 元
				</td>
			</tr>
			<tr>
				<th><label for="">配送方式</label></th>
				<td>
					<?php  if($item['goodstype']) { ?><?php  if($item['sendtype'] == 1) { ?><span class="label label-info">快递</span><?php  } else if($item['sendtype'] == 2) { ?><span class="label label-info">自提</span><?php  } ?><?php  } else { ?>无<?php  } ?>
				</td>
			</tr>
			<tr>
				<th><label for="">付款方式</label></th>
				<td>
					<?php  if($item['paytype'] == 1) { ?>余额支付<?php  } ?>
					<?php  if($item['paytype'] == 2) { ?>在线支付<?php  } ?>
					<?php  if($item['paytype'] == 3) { ?>货到付款<?php  } ?>
				</td>
			</tr>
			<tr>
				<th><label for="">订单状态</label></th>
				<td>
					<?php  if($item['status'] == 0) { ?><span class="label label-info">待付款</span><?php  } ?>
					<?php  if($item['status'] == 1) { ?><span class="label label-info">待发货</span><?php  } ?>
					<?php  if($item['status'] == 2) { ?><span class="label label-info">待收货</span><?php  } ?>
					<?php  if($item['status'] == 3) { ?><span class="label label-success">已完成</span><?php  } ?>
					<?php  if($item['status'] == -1) { ?><span class="label label-success">已关闭</span><?php  } ?>
				</td>
			</tr>
			<tr>
				<th><label for="">下单日期</label></th>
				<td>
					<?php  echo date('Y-m-d H:i:s', $item['createtime'])?>
				</td>
			</tr>
			<tr>
				<th>备注</th>
				<td>
					<textarea style="height:150px;" class="span7" name="remark" cols="70"><?php  echo $item['remark'];?></textarea>
				</td>
			</tr>
		</table>
		<h4>用户信息</h4>
		<table class="tb">
			<tr>
				<th><label for="">姓名</label></th>
				<td>
					<?php  echo $item['user']['realname'];?>
				</td>
			</tr>
			<tr>
				<th><label for="">手机</label></th>
				<td>
					<?php  echo $item['user']['mobile'];?>
				</td>
			</tr>
			<tr>
				<th><label for="">QQ</label></th>
				<td>
					<?php  echo $item['user']['qq'];?>
				</td>
			</tr>
			<tr>
				<th><label for="">地址</label></th>
				<td>
					<?php  echo $item['user']['province'];?> - <?php  echo $item['user']['city'];?> - <?php  echo $item['user']['area'];?> - <?php  echo $item['user']['address'];?>
				</td>
			</tr>
		</table>
		<h4>商品信息</h4>
		<table class="table table-hover">
			<thead class="navbar-inner">
				<tr>
					<th style="width:30px;">ID</th>
					<th style="min-width:150px;">商品标题</th>
					<th style="width:100px;">商品编号</th>
					<th style="width:100px;">商品条码</th>
					<th style="width:100px;">销售价/成本价</th>
					<th style="width:100px;">属性</th>
					<th style="width:100px;">数量</th>
					<th style="text-align:right; min-width:60px;">操作</th>
				</tr>
			</thead>
			<?php  if(is_array($item['goods'])) { foreach($item['goods'] as $goods) { ?>
			<tr>
				<td><?php  echo $goods['id'];?></td>
				<td><?php  if($category[$goods['pcate']]['name']) { ?><span class="text-error">[<?php  echo $category[$goods['pcate']]['name'];?>] </span><?php  } ?><?php  if($children[$goods['pcate']][$goods['ccate']]['1']) { ?><span class="text-info">[<?php  echo $children[$goods['pcate']][$goods['ccate']]['1'];?>] </span><?php  } ?><?php  echo $goods['title'];?></td>
				<td><?php  echo $goods['goodssn'];?></td>
				<td><?php  echo $goods['productsn'];?></td>
				<!--td><?php  echo $category[$goods['pcate']]['name'];?> - <?php  echo $children[$goods['pcate']][$goods['ccate']]['1'];?></td-->
				<td style="background:#f2dede;"><?php  echo $goods['marketprice'];?>元 / <?php  echo $goods['productprice'];?>元</td>
				<td><?php  if($goods['status']) { ?><span class="label label-success">上架</span><?php  } else { ?><span class="label label-error">下架</span><?php  } ?>&nbsp;<span class="label label-info"><?php  if($goods['type'] == 1) { ?>实体商品<?php  } else { ?>虚拟商品<?php  } ?></span></td>
				<td><?php  echo $goodsid[$goods['id']]['total'];?></td>
				<td style="text-align:right;">
					<a href="<?php  echo $this->createWebUrl('goods', array('id' => $goods['id'], 'op' => 'post'))?>">编辑</a>&nbsp;&nbsp;<a href="<?php  echo $this->createWebUrl('goods', array('id' => $goods['id'], 'op' => 'delete'))?>" onclick="return confirm('此操作不可恢复，确认删除？');return false;">删除</a>
				</td>
			</tr>
			<?php  } } ?>
		</table>
		<table class="tb">
			<tr>
				<th></th>
				<td>
					<?php  if(empty($item['status'])) { ?>
						<button type="submit" class="btn btn-primary span2" onclick="return confirm('确认付款此订单吗？'); return false;" name="confrimpay" onclick="" value="yes">确认付款</button>
					<?php  } else if($item['status'] == 1) { ?>
						<?php  if($item['sendtype'] == '1') { ?>
						<button type="button" class="btn btn-primary span2" name="confirmsend" onclick="$('#modal-confirmsend').modal()" value="yes">确认发货</button>
						<button type="button" class="btn btn-danger span2" name="cancelsend" onclick="$('#modal-cancelsend').modal();" value="yes">取消发货</button>
						<?php  } ?>
					<?php  } else if($item['status'] == 2) { ?>
						<?php  if($item['sendtype'] == '1') { ?>
						<button type="button" class="btn btn-danger span2" name="cancelsend" onclick="$('#modal-cancelsend').modal();" value="yes">取消发货</button>
						<?php  } ?>
						<button type="submit" class="btn btn-success span2" onclick="return confirm('确认完成此订单吗？'); return false;" name="finish" onclick="" value="yes">完成订单</button>
					<?php  } else if($item['status'] == 3) { ?>

					<?php  } ?>
					<button type="button" class="btn span2" name="close" onclick="$('#modal-close').modal()" value="关闭">关闭订单</button>
					<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
				</td>
			</tr>
		</table>
		<div id="modal-confirmsend" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true" style=" width:600px;">
			<div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>快递信息</h3></div>
			<div class="modal-body">
				<table class="tb">
					<tr>
						<th><label for="">是否需要快递</label></th>
						<td>
							<label for="radio_1" class="radio inline"><input type="radio" name="isexpress" id="radio_1" value="1" onclick="$('#expresspanel').show();" checked autocomplete="off"> 是</label>
							<label for="radio_2" class="radio inline"><input type="radio" name="isexpress" id="radio_2" value="0" onclick="$('#expresspanel').hide();" autocomplete="off"> 否</label>
						</td>
					</tr>
					<tbody id="expresspanel">
						<tr>
							<th><label for="">快递公司</label></th>
							<td>
								<select name="expresscom">
									<option value="申通E物流">申通E物流</option>
									<option value="百世汇通">百世汇通</option>
									<option value="中通速递">中通速递</option>
									<option value="圆通速递">圆通速递</option>
									<option value="韵达快运">韵达快运</option>
									<option value="EMS经济快递">EMS经济快递</option>
									<option value="EMS">EMS</option>
									<option value="中国邮政平邮">中国邮政平邮</option>
									<option value="宅急送">宅急送</option>
									<option value="联邦快递">联邦快递</option>
									<option value="顺丰速运">顺丰速运</option>
									<option value="黑猫宅急便">黑猫宅急便</option>
									<option value="优速快递">优速快递</option>
									<option value="天天快递">天天快递</option>
									<option value="百世物流">百世物流</option>
									<option value="德邦物流">德邦物流</option>
									<option value="中铁快运">中铁快运</option>
									<option value="邮政国内小包">邮政国内小包</option>
									<option value="国通快递">国通快递</option>
									<option value="其他">其他</option>
								</select>
							</td>
						</tr>
						<tr>
							<th><label for="">快递单号</label></th>
							<td>
								<input type="text" name="expresssn" class="span5" />
							</td>
						</tr>
					</tbody>
				</table>
				<div id="module-menus"></div>
			</div>
			<div class="modal-footer"><button type="submit" class="btn btn-primary span2" name="confirmsend" value="yes">确认发货</button><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">关闭</a></div>
		</div>
		<div id="modal-cancelsend" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true" style=" width:600px;">
			<div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>取消发货</h3></div>
			<div class="modal-body">
				<table class="tb">
					<tr>
						<th><label for="">取消发货原因</label></th>
						<td>
							<textarea style="height:150px;" class="span5" name="cancelreson" cols="70" autocomplete="off"></textarea>
						</td>
					</tr>
				</table>
				<div id="module-menus"></div>
			</div>
			<div class="modal-footer"><button type="submit" class="btn btn-primary span2" name="cancelsend" value="yes">取消发货</button><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">关闭</a></div>
		</div>
		<div id="modal-close" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true" style=" width:600px;">
			<div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>关闭订单</h3></div>
			<div class="modal-body">
				<table class="tb">
					<tr>
						<th><label for="">关闭订单原因</label></th>
						<td>
							<textarea style="height:150px;" class="span5" name="reson" cols="70" autocomplete="off"></textarea>
						</td>
					</tr>
				</table>
				<div id="module-menus"></div>
			</div>
			<div class="modal-footer"><button type="submit" class="btn btn-primary span2" name="close" value="yes">关闭订单</button><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">关闭</a></div>
		</div>
	</form>
</div>
<?php  } ?>
<?php  include $this->template('common/footer', TEMPLATE_INCLUDEPATH);?>
