<?php defined('IN_IA') or exit('Access Denied');?><?php  include template('common/header', TEMPLATE_INCLUDEPATH);?>
<ul class="nav nav-tabs">
	<li<?php  if($action == 'style' && empty($do)) { ?> class="active"<?php  } ?>><a href="<?php  echo create_url('site/style');?>">风格管理</a></li>
	<?php  if($do == 'designer') { ?><li class="active"><a href="<?php  echo create_url('site/style/designer', array('templateid' => $templateid));?>">设计风格</a></li><?php  } ?>
	<?php  if($_W['isfounder']) { ?><li <?php  if($do == 'module') { ?> class="active"<?php  } ?>><a href="<?php  echo create_url('site/style/module');?>">模块扩展模板说明</a></li><?php  } ?>
</ul>
<?php  if($do == 'module') { ?>
<div class="main" style="">
	<div class="form-horizontal" style="padding:15px;">
		<div class="alert alert-success">覆盖模块模板HTML或是内容时，需要在当前风格目录即“themes/mobile/<?php  echo $_W['account']['template'];?>”下，新建同名模板，即可修改此模块模板内容。</div>
		<table class="table" style="margin:0;">
			<tr style="font-weight:bold; background:#E9E9E9;">
				<td style="width:360px">源文件</td>
				<td style="width:360px">覆盖文件</td>
				<td></td>
			</tr>
			<?php  if(is_array($templates)) { foreach($templates as $name => $item) { ?>
			<tr class="alert alert-info"><td colspan='3'><?php  echo $_W['modules'][$name]['title'];?></td></tr>
			<?php  if(is_array($item)) { foreach($item as $file) { ?>
			<?php  $targetfile = 'themes/mobile/'.$_W['account']['template']. '/' .$name.'/'.$file;?>
			<tr>
				<td style="width:360px; font-size:12px;">/source/modules/<?php  echo $name;?>/template/mobile/<?php  echo $file;?></td>
				<td style="width:360px; font-size:12px; <?php  if(file_exists(IA_ROOT . '/' .$targetfile)) { ?>color:green<?php  } else { ?>color:red<?php  } ?>"><?php  echo $targetfile;?></td>
				<td><a href="javascript:;" onclick="createtemplate('<?php  echo $name;?>', '<?php  echo $file;?>')">生成重定义模板</a></td>
			</tr>
			<?php  } } ?>
			<?php  } } ?>
		</table>
	</div>
</div>
<script type="text/javascript">
<!--
	function createtemplate(name, file) {
		if (file && confirm('此操作辅助生成您需要重定义的模板空文件，你也可以在文件目录中手动添加或是修改些文件，是否确定要生成吗？')) {
			ajaxopen('site.php?act=style&do=createtemplate&name='+name+'&file='+file, function(msg, url ,type){
				location.reload();
			});
		}
	}
//-->
</script>
<?php  } else if($do == 'designer') { ?>
<div class="main">
	<form id="form" class="form-horizontal form" action="" method="post" enctype="multipart/form-data">
		<input type="hidden" name="templateid" value="<?php  echo $template['id'];?>">
		<h4>微站风格</h4>
		<table class="tb">
			<tr>
				<th><label for="">模板名称</label></th>
				<td>
					<?php  echo $template['title'];?>
				</td>
			</tr>
			<tr>
				<th><label for="">模板路径</label></th>
				<td>
					./themes/mobile/<?php  echo $template['name'];?>
				</td>
			</tr>
			<tr>
				<th><label for="">基础图片目录[imgdir]</label></th>
				<td>
					<input type="text" class="span4" name="style[imgdir]" value="<?php  echo $styles['imgdir']['content'];?>" />
					<span class="help-block">风格基础图片存放的目录，如果为空则默认为./themes/mobile/<?php  echo $template['name'];?>/images目录</span>
				</td>
			</tr>
			<tr>
				<th>首页背景 [indexbgcolor] <br /> [indexbgimg] <br /> [indexbgextra]</th>
				<td>
					<div>
						<input class="span3" type="text" name="style[indexbgcolor]" id="indexbgcolor" value="<?php  echo $styles['indexbgcolor']['content'];?>" placeholder="">
						<input class="colorpicker" target="indexbgcolor" value="<?php  echo $styles['indexbgcolor']['content'];?>" />
					</div>
					<div style="display:block; margin-top:5px;">
						<input class="span3" type="text" name="style[indexbgimg]" id="indexbgimg" value="<?php  echo $styles['indexbgimg']['content'];?>" placeholder="">
						<input type="button" fieldname="indexbgimg" class="btn upload-btn" value="<i class='icon-upload-alt'></i> 上传" style="font-size:14px;width:80px;">
					</div>
					<div style="margin-top:5px;"><input class="span3" type="text" name="style[indexbgextra]" value="<?php  echo $styles['indexbgextra']['content'];?>" placeholder=""><span class="help-inline">附加属性</span></div>
					<div style="margin-top:5px;" id="indexbgimg_preview"><img src="<?php  echo $_W['attachurl'];?><?php  echo $styles['indexbgimg']['content'];?>" width="100" /></div>
					<span class="help-block">上传背景图片后，需要提交生效</span>
				</td>
			</tr>
			<tr>
				<th><label for="">正常字体</label>[fontfamily]</th>
				<td>
					<input type="text" class="span4" name="style[fontfamily]" value="<?php  echo $styles['fontfamily']['content'];?>" />
					<span class="help-block"></span>
				</td>
			</tr>
			<tr>
				<th><label for="">正常字体大小</label>[fontsize]</th>
				<td>
					<input type="text" class="span4" name="style[fontsize]" value="<?php  echo $styles['fontsize']['content'];?>" />
					<span class="help-block"></span>
				</td>
			</tr>
			<tr>
				<th><label for="">普通文本颜色</label>[fontcolor]</th>
				<td>
					<input type="text" class="span3" id="fontcolor" name="style[fontcolor]" value="<?php  echo $styles['fontcolor']['content'];?>" />
					<input class="colorpicker" target="fontcolor" value="<?php  echo $styles['fontcolor']['content'];?>" />
					<span class="help-block"></span>
				</td>
			</tr>
			<tr>
				<th><label for="">菜单文本颜色</label>[fontnavcolor]</th>
				<td>
					<input type="text" class="span3" id="fontnavcolor" name="style[fontnavcolor]" value="<?php  echo $styles['fontnavcolor']['content'];?>" />
					<input class="colorpicker" target="fontnavcolor" value="<?php  echo $styles['fontnavcolor']['content'];?>" />
					<span class="help-block"></span>
				</td>
			</tr>
			<tr>
				<th><label for="">链接文字颜色</label>[linkcolor]</th>
				<td>
					<input type="text" class="span3" id="linkcolor" name="style[linkcolor]" value="<?php  echo $styles['linkcolor']['content'];?>" />
					<input class="colorpicker" target="linkcolor" value="<?php  echo $styles['linkcolor']['content'];?>" />
					<span class="help-block"></span>
				</td>
			</tr>
			<tr>
				<th>扩展CSS</th>
				<td>
					<textarea name="style[css]" class="span8" cols="120" rows="16"><?php  echo $styles['css']['content'];?></textarea>
					<span class="help-block">附加一些CSS样式</span>
				</td>
			</tr>
		</table>
		<h4>自定义属性</h4>
		<table class="tb">
			<tbody id="customForm">
				<?php  if(is_array($styles)) { foreach($styles as $style) { ?>
				<?php  if(!in_array($style['variable'], $systemtags)) { ?>
					<tr>
						<th><input type="text" name="custom[name][]" class="span2" value="<?php  echo $style['variable'];?>" /></th>
						<td><input type="text" name="custom[value][]" class="span4" value="<?php  echo $style['content'];?>" /></td>
					</tr>
				<?php  } ?>
				<?php  } } ?>
			</tbody>
			<tr>
				<td colspan="7">
					<a href="javascript:;" onclick="addFormItem()"><i class="icon-plus-sign-alt"></i> 添加新变量</a>
				</td>
			</tr>
			<tr>
				<th></th>
				<td>
					<input name="token" type="hidden" value="<?php  echo $_W['token'];?>" />
					<input type="submit" class="btn btn-primary" name="submit" id="submit" value="提交" />
				</td>
			</tr>
		</table>
	</form>
</div>
<script type="text/javascript" src="./resource/script/colorpicker/spectrum.js"></script>
<link type="text/css" rel="stylesheet" href="./resource/script/colorpicker/spectrum.css" />
<link type="text/css" rel="stylesheet" href="./resource/script/kindeditor/themes/default/default.css" />
<script type="text/html" id="item-form-html">
	<tr>
		<th><input type="text" name="custom[name][]" class="span2" /></th>
		<td><input type="text" name="custom[value][]" class="span4" /></td>
	</tr>
</script>
<script type="text/javascript">
<!--
	$('.upload-btn').each(function(){
		kindeditorUploadBtn($(this), uploadHander);
	});

	function uploadHander(obj, data) {
		$("#"+obj.button.attr('fieldname')).val(data.filename);
		$("#"+obj.button.attr('fieldname') + '_preview').html('<img src="'+data.url+'" width="100" />');
	}

	function buildForm() {
		$('#append-list').append($('#item-form-html').html());
	}

	function doDeleteItemImage(id) {
		var filename = $('#' + id).val();
		ajaxopen('./index.php?act=attachment&do=delete&filename=' + filename, function(){
			$('#' + id).val('');
			$('#submit').trigger('click');
		});
	}

	function addFormItem() {
		$('#customForm').append($('#item-form-html').html());

	}

	$(function(){
		colorpicker();
	});
//-->
</script>
<?php  } else { ?>
<style>
.template-style{display:block;}
.template-style li{float:left; width:180px; margin:0 2px 10px 2px;}
.template-style .template-style-pic .title{position:absolute; z-index:100; top:0; width:100%; height:25px; line-height:25px; filter:Alpha(opacity=70);background:#000;background:rgba(0, 0, 0, 0.7); color:#FFF; overflow:hidden;}
.title .icon-remove{position:absolute; right:0; background:#000; border-left:1px #333 solid; height:25px;line-height:26px;width:20px;text-align:center;cursor:pointer; text-decoration:none;}
.title .pull-left{margin-left:5px;}
.template-style .template-style-pic img{width:174px; max-width:174px; height:270px;}
.template-style .template-style-pic{border:3px #EEE solid;position:relative;overflow:hidden;}
.template-style .template-style-pic .icon-ok{display:none;}
.template-style .on.template-style-pic{border:3px #009CD6 solid;}
.template-style .on.template-style-pic .icon-ok{display:inline-block;position: absolute;bottom:0;right:0;color:#FFF;background:#009CD6;padding:5px;font-size:14px;}
.template-style .template-style-button{height:50px; line-height:25px;}
.template{padding:15px;}
.template li{margin-right:10px;}
</style>
<div class="main">
	<div class="template form-horizontal">
		<div class="alert alert-info">已安装的风格</div>
		<ul class="unstyled template-style clearfix">
		<?php  if(is_array($templates)) { foreach($templates as $item) { ?>
		<li>
			<div class="template-style-pic <?php  if($_W['account']['styleid'] == $item['id']) { ?>on<?php  } ?>"> <!--设为默认风格时class中加on-->
				<div class="title"><span class="pull-left"><?php  echo $item['title'];?> (<?php  echo $item['name'];?>)</span></div>
				<img src="./themes/mobile/<?php  echo $item['name'];?>/preview.jpg" />
				<span class="icon-ok"></span>
			</div>
			<div class="template-style-button">
				<a href="javascript:;" onclick="ajaxpreview('<?php  echo $item['id'];?>');return false;" class="btn btn-mini pull-right" style="margin-top:4px;">预览</a>
				<a href="<?php  echo create_url('site/style/default', array('templateid' => $item['id']))?>" class="btn btn-mini">设为默认</a>
				<a href="<?php  echo create_url('site/style/designer', array('templateid' => $item['id']))?>" class="btn btn-mini">设计风格</a>
			</div>
		</li>
		<?php  } } ?>
		</ul>
	</div>
</div>
<script type="text/javascript">
<!--
	function ajaxpreview(styleid) {
		var modalobj = $('#modal-preview');
		if(modalobj.length == 0) {
			$(document.body).append('<div id="modal-preview" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true" style="position:absolute;top:5%;"></div>');
			var modalobj = $('#modal-preview');
		}
		html = '<iframe width="100%" scrolling="yes" height="100%" frameborder="0" src="<?php  echo create_url('site/preview')?>&styleid='+styleid+'" id="preview" name="preview" style="width: 320px; overflow: visible; height: 480px;"></iframe><div class="modal-footer"><a href="<?php  echo $_W['siteroot'];?><?php  echo create_url('mobile/channel', array('name' => 'index', 'weid' => $_W['weid']))?>&styleid='+styleid+'" target="preview" class="btn">首页</a><a href="<?php  echo $_W['siteroot'];?><?php  echo create_url('mobile/channel', array('name' => 'home', 'weid' => $_W['weid']))?>" target="preview" class="btn">个人中心</a><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">关闭</a></div>';
		modalobj.html(html);
		modalobj.css({'width' : 320, 'marginLeft' : 0 - 320 / 2});
		modalobj.css({'height' : 480});
		modalobj.on('hidden', function(){modalobj.remove();});
		return modalobj.modal({'show' : true});
	}
//-->
</script>
<?php  } ?>
<?php  include template('common/footer', TEMPLATE_INCLUDEPATH);?>
