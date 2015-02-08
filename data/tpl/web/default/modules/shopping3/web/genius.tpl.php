<?php defined('IN_IA') or exit('Access Denied');?><?php  include $this->template('common/header', TEMPLATE_INCLUDEPATH);?>
<link rel="stylesheet" type="text/css" href="./source/modules/shopping3/style/css/uploadify_t.css" media="all" />
<ul class="nav nav-tabs">
	<li <?php  if($operation == 'post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('genius', array('op' => 'post'))?>">添加智能选菜</a></li>
	<li <?php  if($operation == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('genius', array('op' => 'display'))?>">管理智能选菜</a></li>
</ul>
<?php  if($operation == 'post') { ?>
<div class="main">
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?php  echo $item['id'];?>" />
		<h4>添加智能选菜</h4>
		<table class="tb">
			<tr>
				<th><label for="">排序</label></th>
				<td>
					<input type="text" name="displayorder" class="span2" value="<?php  echo $item['displayorder'];?>" />   
				</td>
			</tr>
		 
			<tr>
				<th><label for="">适合人数</label></th>
				<td>
					<input type="text" name="rens" id="rens" class="span2" value="<?php  echo $item['rens'];?>" />
				</td>
			</tr>

			<tr>
				<th><label for="">是否显示</label></th>
				<td>
					<label for="isshow1" class="radio inline"><input type="radio" name="status" value="1" id="isshow1" <?php  if($item['status'] == 1) { ?>checked="true"<?php  } ?> /> 是</label>
					&nbsp;&nbsp;&nbsp;
					<label for="isshow2" class="radio inline"><input type="radio" name="status" value="0" id="isshow2"  <?php  if($item['status'] == 0) { ?>checked="true"<?php  } ?> /> 否</label>
					<span class="help-block"></span>
				</td>
			</tr>
 			<tr>
				<th><label for="">菜品选择</label></th>
				<td>
					<table class="dataTable-mini" id="more_graphics_table">
					<tbody id="more_graphics_tabletr_<?php  echo $_W['weid'];?>" >
 					</tbody>
					<?php  $goodsArr='';?>
					<?php  if(is_array($item['dishes']['title'])) { foreach($item['dishes']['title'] as $key => $row) { ?>
					<?php  $goodsArr.=$item['dishes']['id'][$key].",";?>
					<tr draggable="true" data-id="<?php  echo $item['dishes']['id'][$key];?>" ><td><input type="hidden" name="dishes[title][]" value="<?php  echo $row;?>"><input type="hidden" name="dishes[id][]" value="<?php  echo $item['dishes']['id'][$key];?>"><?php  echo $row;?></td><td><input name="dishes[num][]"  type="text" class="input-mini nums" data-rule-integer="true" value="<?php  echo $item['dishes']['num'][$key];?>"></td><td><a href="javascript:void(0)" class="btn btn-mini del"><i class="icon-remove"></i></a></td></tr>
					<?php  } } ?>
					</table>
					<button class="btn span2" type="button" onclick="popwin = $('#modal-module-menus').modal();">选择要添加的菜品</button>
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
<div id="modal-module-menus" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true" style=" width:600px;">
	<div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>选择要添加的菜品</h3></div>
	<div class="modal-body">
		<table class="tb">
			<tr>
				<th><label for="">菜品分类:</label></th>
				<td>
					<div class="input-append" style="display:block;">
						<!--input type="text" class="span3" name="keyword" value="" id="search-kwd" />-->
                            <select name="classid" id="classid" class="input-medium">
                                <option value="" selected="selected">全部</option>
								<?php  if(is_array($category)) { foreach($category as $row) { ?>
								<?php  if($row['parentid'] == 0) { ?>
									<option value="<?php  echo $row['id'];?>" <?php  if($row['id'] == $item['pcate']) { ?> selected="selected"<?php  } ?>><?php  echo $row['name'];?></option>
								<?php  } ?>
								<?php  } } ?>
							</select>
							<button type="button" class="btn" onclick="search_entries();">搜索</button>
					</div>
				</td>
			</tr>
		</table>
		<div id="module-menus"></div>
	</div>
	<div class="modal-footer"><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">关闭</a></div>
</div>
<script type="text/javascript">
	var popwin;
	var goodsArr='<?php  echo $goodsArr;?>';
	function search_entries() {
		var classid = $.trim($('#classid').val());
		$.post('<?php  echo $this->createWebUrl('genius',array('op'=>'query'));?>', {classid: classid}, function(dat){
			$('#module-menus').html(dat);
		});
	}
	function select_entry(o) {
		if(goodsArr.indexOf(o.id+',')==-1){
			var html = '<tr draggable="true" data-id="'+o.id+'" ><td><input type="hidden" name="dishes[title][]" value="'+o.title+'"><input type="hidden" name="dishes[id][]" value="'+o.id+'">'+o.title+'</td><td><input name="dishes[num][]" data-price="22" type="text" class="input-mini nums" data-rule-integer="true" value="1"></td><td><a href="javascript:void(0)" class="btn btn-mini del"><i class="icon-remove"></i></a></td></tr>';
			goodsArr+=o.id+',';
		}else{
			html='';
		}
		$("#more_graphics_tabletr_<?php  echo $_W['weid'];?>").append(html);
 	}
	//删除
	$("table.dataTable-mini .del").live("click", function () {
		obj=$(this).parent().parent();
		goodsid=obj.attr('data-id');
		goodsArr = goodsArr.replace(goodsid+",","");
		obj.remove();
	});

	
</script>
<?php  } else if($operation == 'display') { ?>
<div class="main">

	<div style="padding:15px;">
		<form action="" method="post" onsubmit="return formcheck(this)">				
		<table class="table table-hover">
			<thead class="navbar-inner">
				<tr>
					<th style="width:10px;"></th>
 					<th style="width:80px;">显示顺序</th>
					<th style="width:80px;">适用人数</th>
					<th style="width:80px;">菜品品种</th>
					<th style="min-width:150px;">菜品数量</th>
					<th style="width:80px;">状态</th>
					<th style="text-align:right; min-width:100px;">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
					<td></td>
					<td><input type="text" class="span1" name="displayorder[<?php  echo $item['id'];?>]" value="<?php  echo $item['displayorder'];?>"></td>				
					<td><?php  echo $item['rens'];?></td>				
					<td><?php  echo $item['sort'];?></td>									
					<td><?php  echo $item['nums'];?></td>									
					<td><?php  if($item['status']) { ?><span class="label label-success">显示</span><?php  } else { ?><span class="label label-error">隐藏</span><?php  } ?></td>
					<td style="text-align:right;">
						<a href="<?php  echo $this->createWebUrl('genius', array('id' => $item['id'], 'op' => 'post'))?>">编辑</a>&nbsp;&nbsp;<a href="<?php  echo $this->createWebUrl('genius', array('id' => $item['id'], 'op' => 'delete'))?>" onclick="return confirm('此操作不可恢复，确认删除？');return false;">删除</a>
					</td>
				</tr>
				<?php  } } ?>
			</tbody>
			<tr>
				<td></td>
				<td colspan="3">
					<input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
					<input type="submit" class="btn btn-primary" name="submit" value="提交" />
				</td>
			</tr>
		</table>
		</form>
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