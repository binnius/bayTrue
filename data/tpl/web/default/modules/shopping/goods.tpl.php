<?php defined('IN_IA') or exit('Access Denied');?><?php  include $this->template('common/header', TEMPLATE_INCLUDEPATH);?>
<ul class="nav nav-tabs">
	<li <?php  if($operation == 'post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('goods', array('op' => 'post'))?>">添加商品</a></li>
	<li <?php  if($operation == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('goods', array('op' => 'display'))?>">管理商品</a></li>
</ul>
<?php  if($operation == 'post') { ?>
<div class="main">
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?php  echo $item['id'];?>" />
		<h4>商品基本信息</h4>
		<table class="tb">
			<tr>
				<th><label for="">排序</label></th>
				<td>
					<input type="text" name="displayorder" class="span1" value="<?php  echo $item['displayorder'];?>" />
				</td>
			</tr>
			<tr>
				<th>分类</th>
				<td>
					<select class="span3" style="margin-right:15px;" name="pcate" onchange="fetchChildCategory(this.options[this.selectedIndex].value)"  autocomplete="off">
						<option value="0">请选择一级分类</option>
						<?php  if(is_array($category)) { foreach($category as $row) { ?>
						<?php  if($row['parentid'] == 0) { ?>
						<option value="<?php  echo $row['id'];?>" <?php  if($row['id'] == $item['pcate']) { ?> selected="selected"<?php  } ?>><?php  echo $row['name'];?></option>
						<?php  } ?>
						<?php  } } ?>
					</select>
					<select class="span3" id="cate_2" name="ccate" autocomplete="off">
						<option value="0">请选择二级分类</option>
						<?php  if(!empty($item['ccate']) && !empty($children[$item['pcate']])) { ?>
						<?php  if(is_array($children[$item['pcate']])) { foreach($children[$item['pcate']] as $row) { ?>
						<option value="<?php  echo $row['0'];?>" <?php  if($row['0'] == $item['ccate']) { ?> selected="selected"<?php  } ?>><?php  echo $row['1'];?></option>
						<?php  } } ?>
						<?php  } ?>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="">商品名称</label></th>
				<td>
					<input type="text" name="goodsname" class="span6" value="<?php  echo $item['title'];?>" />
				</td>
			</tr>
			<tr>
				<th><label for="">商品单位</label></th>
				<td>
					<input type="text" name="unit" class="span2" value="<?php  echo $item['unit'];?>" />
				</td>
			</tr>
			<tr>
				<th><label for="">商品类型</label></th>
				<td>
					<label for="isshow3" class="radio inline"><input type="radio" name="type" value="1" id="isshow3" <?php  if(empty($item) || $item['type'] == 1) { ?>checked="true"<?php  } ?> onclick="$('#product').show()" /> 实体商品</label>&nbsp;&nbsp;&nbsp;<label for="isshow4" class="radio inline"><input type="radio" name="type" value="2" id="isshow4"  <?php  if($item['type'] == 2) { ?>checked="true"<?php  } ?>  onclick="$('#product').hide()" /> 虚拟商品</label>
					<span class="help-block">虚拟商品，例如：优惠券，打折卡等，需要用户去店里消费使用的。实体商品，需要进行用户自提或是邮递的商品。</span>
				</td>
			</tr>
			<tr>
				<th><label for="">缩略图</label></th>
				<td>
					<?php  echo tpl_form_field_image('thumb', $item['thumb']);?>
					<span class="help-block"></span>
				</td>
			</tr>
			<tr>
				<th><label for="">商品编号</label></th>
				<td>
					<input type="text" name="goodssn" class="span6" value="<?php  echo $item['goodssn'];?>" />
				</td>
			</tr>
		</table>
		<div id="normalForm" <?php  if(!empty($item['spec'])) { ?> style="display:none;"<?php  } ?>>
			<h4>商品扩展信息</h4>
			<table class="tb">
			<!--tr>
				<td colspan="2">
					<input name="spec" type="button" onclick="$('#specWin').modal();" value="添加规格" class="btn span2">
				</td>
			</tr-->
			<tr>
				<th>货号</th>
				<td>
					<input type="text" name="productsn-row" class="span3" value="<?php  echo $item['productsn'];?>" />
				</td>
			</tr>
			<tr>
				<th>销售价</th>
				<td>
					<input type="text" name="marketprice-row" class="span1" value="<?php  echo $item['marketprice'];?>" /> 元
				</td>
			</tr>
			<tr>
				<th>成本价</th>
				<td>
					<input type="text" name="productprice-row" class="span1" value="<?php  echo $item['productprice'];?>" /> 元
				</td>
			</tr>
			<tr>
				<th>库存</th>
				<td>
					<input type="text" name="total-row" class="span1" value="<?php  if($item['total'] != '-1') { ?><?php  echo $item['total'];?><?php  } ?>" /> <label class="checkbox inline"><input type="checkbox" name="unlimited-row[]" <?php  if($item['total'] == '-1') { ?> checked<?php  } ?> value="1" /> 无限库存</label>
				</td>
			</tr>
			<tr>
				<th>是否上架</th>
				<td>
					<label class="checkbox"><input type="checkbox" name="status-row[]" value="1" checked /></label>
				</td>
			</tr>
		</table>
		</div>
		<!--
		<div id="specForm" <?php  if(empty($item['spec'])) { ?> style="display:none;"<?php  } ?>>
			<h4>商品扩展信息</h4>
			<table class="tb">
				<tr>
					<td colspan="2" id="specs">
					<?php  if(!empty($item['spec'])) { ?>
					<?php  if(is_array($item['spec'])) { foreach($item['spec'] as $id => $specitem) { ?>
					<div style="margin-left: 5px;" class="pull-left" id="spec_<?php  echo $id;?>"><span class="label label-info"><?php  echo $specitem;?></span><a onclick="deleteSpec(<?php  echo $id;?>)" href="javascript:;">删除</a><input type="hidden" value="<?php  echo $id;?>" name="spec[id][]"><input type="hidden" value="<?php  echo $specitem;?>" name="spec[title][]"></div>
					<?php  } } ?>
					<?php  } ?>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input name="spec" type="button" onclick="<?php  if(!empty($products)) { ?>
		message('如果要添加新的规格请先删除所有产品。', '<?php  echo $this->createWebUrl('goods', array('op' => 'post', 'id' => $id))?>');return false;
		<?php  } ?>$('#specWin').modal()" value="添加规格" class="btn span2">&nbsp;&nbsp;<input type="button" onclick="addProduct()" value="添加产品" class="btn span2">
					</td>
				</tr>
			</table>
			<table class="table table-hover">
				<thead class="navbar-inner">
					<tr id="product-header">
						<?php  if(!empty($item['spec'])) { ?>
						<?php  if(is_array($item['spec'])) { foreach($item['spec'] as $specitem) { ?>
						<th><?php  echo $specitem;?></th>
						<?php  } } ?>
						<?php  } ?>
						<th style="width:120px;">货号</th>
						<th style="min-width:150px;">销售价</th>
						<th style="width:100px;">成本价</th>
						<th style="width:100px;">库存</th>
						<th style="width:100px;">是否上架</th>
						<th style="text-align:right; width:20px;">操作</th>
					</tr>
				</thead>
				<tbody id="product-body">
					<?php  if(!empty($products)) { ?>
					<?php  if(is_array($products)) { foreach($products as $productitem) { ?>
					<tr id="product_<?php  echo $productitem['id'];?>">
						<?php  if(!empty($item['spec'])) { ?>
						<?php  if(is_array($item['spec'])) { foreach($item['spec'] as $id => $specitem) { ?>
						<td>
							<select name="specvalue[<?php  echo $id;?>][<?php  echo $productitem['id'];?>]">
								<?php  if(is_array($specs[$id]['content'])) { foreach($specs[$id]['content'] as $contentitem) { ?>
								<option <?php  if($productitem['spec'][$id] == $contentitem) { ?>selected<?php  } ?>><?php  echo $contentitem;?></option>
								<?php  } } ?>
							</select>
						</td>
						<?php  } } ?>
						<?php  } ?>
						<td><input type="text" name="productsn[<?php  echo $productitem['id'];?>]" class="span3" value="<?php  echo $productitem['productsn'];?>" /></td>
						<td><input type="text" name="marketprice[<?php  echo $productitem['id'];?>]" class="span1" value="<?php  echo $productitem['marketprice'];?>" /> 元</td>
						<td><input type="text" name="productprice[<?php  echo $productitem['id'];?>]" class="span1" value="<?php  echo $productitem['productprice'];?>" /> 元</td>
						<td><input type="text" name="total[<?php  echo $productitem['id'];?>]" class="span1" value="<?php  if($productitem['total'] != '-1') { ?><?php  echo $productitem['total'];?><?php  } ?>" /> <label class="checkbox inline"><input type="checkbox" onclick="$(this).parent().find('input[name=\'unlimited[<?php  echo $productitem['id'];?>]\']').val(this.checked ? 1 : 0)" <?php  if($productitem['total'] == '-1') { ?>checked<?php  } ?> /> 无限库存 <input type="hidden" name="unlimited[<?php  echo $productitem['id'];?>]" value="<?php  if($productitem['total'] == '-1') { ?>1<?php  } else { ?>0<?php  } ?>" /></label></td>
						<td>
							<label class="checkbox"><input type="checkbox" name="status[<?php  echo $productitem['id'];?>]" value="1" <?php  if(!isset($productitem['status']) || $productitem['status'] == '1') { ?>checked<?php  } ?> /></label>
							<span class="help-block"></span>
						</td>
						<td><a href="<?php  echo $this->createWebUrl('goods', array('op' => 'productdelete', 'id' => $productitem['id']))?>" onclick="doDeleteItem('product_<?php  echo $productitem['id'];?>', this.href); return false;">删除</a></td>
					</tr>
					<?php  } } ?>
					<?php  } ?>
					<tr>
						<?php  if(!empty($item['spec'])) { ?>
						<?php  if(is_array($item['spec'])) { foreach($item['spec'] as $id => $specitem) { ?>
						<td>
							<select name="specvalue-new[<?php  echo $id;?>][]">
								<?php  if(is_array($specs[$id]['content'])) { foreach($specs[$id]['content'] as $contentitem) { ?>
								<option><?php  echo $contentitem;?></option>
								<?php  } } ?>
							</select>
						</td>
						<?php  } } ?>
						<?php  } ?>
						<td><input type="text" name="productsn-new[]" class="span3" value="" /></td>
						<td><input type="text" name="marketprice-new[]" class="span1" value="" /> 元</td>
						<td><input type="text" name="productprice-new[]" class="span1" value="" /> 元</td>
						<td><input type="text" name="total-new[]" class="span1" value="" /> <label class="checkbox inline"><input type="checkbox" onclick="$(this).parent().find('input[name=\'unlimited-new[]\']').val(this.checked ? 1 : 0)" /> 无限库存 <input type="hidden" name="unlimited-new[]" value="0" /></label></td>
						<td>
							<label class="checkbox"><input type="checkbox" name="status-new[]" value="1" checked /></label>
							<span class="help-block"></span>
						</td>
						<td><a href="javascript:;">删除</a></td>
					</tr>
				</tbody>
			</table>
		</div>
		-->
		<h4>商品描述信息</h4>
		<table class="tb">
			<tr>
				<th>简介</th>
				<td>
					<textarea style="height:150px;" class="span7" name="description" cols="70"><?php  echo $item['description'];?></textarea>
				</td>
			</tr>
			<tr>
				<th>内容</th>
				<td>
					<textarea style="height:200px;" class="span7 richtext-clone" name="content" cols="70"><?php  echo $item['content'];?></textarea>
				</td>
			</tr>
			<tr>
				<th></th>
				<td>
					<input name="submit" type="submit" value="提交" class="btn btn-primary span3">
					<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
				</td>
			</tr>
		</table>
	</form>
</div>
<div id="specWin" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
	<table class="table table-hover">
		<thead class="navbar-inner">
			<tr>
				<th style="width:100px;" class="row-hover">名称<i></i></th>
				<th style="text-align:right;">操作</th>
			</tr>
		</thead>
		<tbody id="spec-items">
		<?php  if(is_array($specs)) { foreach($specs as $field) { ?>
			<?php  $json = json_encode($field);?>
			<tr>
				<td><input  name="spec[]" type="text" value="<?php  echo $field['title'];?>"></td>
				<td style="text-align:right;">
					<?php  if(is_array($field['content'])) { foreach($field['content'] as $item) { ?>
					<span class="label label-info"><?php  echo $item;?></span>
					<?php  } } ?>
				</td>
				<td><a href="javascript:;" onclick='addSpec(<?php  echo $json;?>)'>添加</a></td>
			</tr>
		<?php  } } ?>
		</tbody>
	</table>
</div>
<script type="text/javascript">
<!--
	var category = <?php  echo json_encode($children)?>;
	kindeditor($('.richtext-clone'));

	function addSpec(spec) {
		if ($('#spec_'+spec['id'])[0]) {
			return false;
		}
		var html = '<div id="spec_'+spec['id']+'" class="pull-left" style="margin-left:5px;"><span class="label label-info">'+spec['title']+'</span><a href="javascript:;" onclick="deleteSpec('+spec['id']+')">删除</a><input type="hidden" name="spec[id][]" value="'+spec['id']+'" /><input type="hidden" name="spec[title][]" value="'+spec['title']+'" /></div>';
		$('#specs').append($(html));
		var option = '';
		for (var i in spec['content']) {
			option += '<option>'+spec['content'][i]+'</option>';
		}
		$('#product-header').prepend('<th id="th_'+spec['id']+'">'+spec['title']+'</th>');
		$('#product-body tr').prepend('<td class="td_'+spec['id']+'"><select name="specvalue['+spec['id']+'][]">'+option+'</select></td>');

		$('#normalForm').hide();
		$('#specForm').show();
	}

	function deleteSpec(id) {
		<?php  if(!empty($products)) { ?>
		message('如果要添加新的规格请先删除所有产品。', '<?php  echo $this->createWebUrl('goods', array('op' => 'post', 'id' => $id))?>');
		return false;
		<?php  } ?>
		$('#product-header #th_'+id).remove();
		$('#product-body tr .td_'+id).remove();
		$('#spec_'+id).remove();

		if ($('#specs div').size() == 0) {
			$('#normalForm').show();
			$('#specForm').hide();
		}
	}

	function addProduct() {
		var tr = $('<tr>' + $('#product-body tr:last').html() + '</tr>');
		$('#product-body').append(tr);
	}
//-->
</script>
<?php  } else if($operation == 'display') { ?>
<div class="main">
	<div class="search">
		<form action="site.php" method="get">
		<input type="hidden" name="act" value="module" />
		<input type="hidden" name="do" value="goods" />
		<input type="hidden" name="op" value="display" />
		<input type="hidden" name="name" value="shopping" />
		<table class="table table-bordered tb">
			<tbody>
				<tr>
					<th>关键字</th>
					<td>
						<input class="span6" name="keyword" id="" type="text" value="<?php  echo $_GPC['keyword'];?>">
					</td>
				</tr>
				<tr>
					<th>状态</th>
					<td>
						<select name="status">
							<option value="1" <?php  if(!empty($_GPC['status'])) { ?> selected<?php  } ?>>上架</option>
							<option value="0" <?php  if(empty($_GPC['status'])) { ?> selected<?php  } ?>>下架</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>分类</th>
					<td>
						<select class="span3" style="margin-right:15px;" name="cate_1" onchange="fetchChildCategory(this.options[this.selectedIndex].value)">
							<option value="0">请选择一级分类</option>
							<?php  if(is_array($category)) { foreach($category as $row) { ?>
							<?php  if($row['parentid'] == 0) { ?>
							<option value="<?php  echo $row['id'];?>" <?php  if($row['id'] == $_GPC['cate_1']) { ?> selected="selected"<?php  } ?>><?php  echo $row['name'];?></option>
							<?php  } ?>
							<?php  } } ?>
						</select>
						<select class="span3" id="cate_2" name="cate_2">
							<option value="0">请选择二级分类</option>
							<?php  if(!empty($_GPC['cate_1']) && !empty($children[$_GPC['cate_1']])) { ?>
							<?php  if(is_array($children[$_GPC['cate_1']])) { foreach($children[$_GPC['cate_1']] as $row) { ?>
							<option value="<?php  echo $row['0'];?>" <?php  if($row['0'] == $_GPC['cate_2']) { ?> selected="selected"<?php  } ?>><?php  echo $row['1'];?></option>
							<?php  } } ?>
							<?php  } ?>
						</select>
					</td>
				</tr>
				<tr>
				 <tr class="search-submit">
					<td colspan="2"><button class="btn pull-right span2"><i class="icon-search icon-large"></i> 搜索</button></td>
				 </tr>
			</tbody>
		</table>
		</form>
	</div>
	<div style="padding:15px;">
		<table class="table table-hover">
			<thead class="navbar-inner">
				<tr>
					<th style="width:30px;">ID</th>
					<th style="min-width:150px;">商品标题</th>
					<th style="width:100px;">商品编号</th>
					<th style="width:100px;">商品条码</th>
					<th style="width:100px;">属性</th>
					<th style="text-align:right; min-width:60px;">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
					<td><?php  echo $item['id'];?></td>
					<td><?php  if(!empty($category[$item['pcate']])) { ?><span class="text-error">[<?php  echo $category[$item['pcate']]['name'];?>] </span><?php  } ?><?php  if(!empty($children[$item['pcate']])) { ?><span class="text-info">[<?php  echo $children[$item['pcate']][$item['ccate']]['1'];?>] </span><?php  } ?><?php  echo $item['title'];?></td>
					<td><?php  echo $item['goodssn'];?></td>
					<td><?php  echo $item['productsn'];?></td>
					<td><?php  if($item['status']) { ?><span class="label label-success">上架</span><?php  } else { ?><span class="label label-error">下架</span><?php  } ?>&nbsp;<span class="label label-info"><?php  if($item['type'] == 1) { ?>实体商品<?php  } else { ?>虚拟商品<?php  } ?></span></td>
					<td style="text-align:right;">
						<a href="<?php  echo $this->createWebUrl('goods', array('id' => $item['id'], 'op' => 'post'))?>">编辑</a>&nbsp;&nbsp;<a href="<?php  echo $this->createWebUrl('goods', array('id' => $item['id'], 'op' => 'delete'))?>" onclick="return confirm('此操作不可恢复，确认删除？');return false;">删除</a>
					</td>
				</tr>
				<?php  } } ?>
			</tbody>
			<tr>
				<td></td>
				<td colspan="6">
					<input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
					<input type="submit" class="btn btn-primary" name="submit" value="提交" />
				</td>
			</tr>
		</table>
		<?php  echo $pager;?>
	</div>
</div>
<script type="text/javascript">
<!--
	var category = <?php  echo json_encode($children)?>;
//-->
</script>
<?php  } ?>
<?php  include $this->template('common/footer', TEMPLATE_INCLUDEPATH);?>
