<?php defined('IN_IA') or exit('Access Denied');?><?php  include template('common/header', TEMPLATE_INCLUDEPATH);?>
<ul class="nav nav-tabs">
	<?php  if($rid) { ?><?php  $defaultmodule = $rule['rule']['module'];?><?php  } ?>
	<li><a href="<?php  echo create_url('rule/display', array('module' => $defaultmodule))?>">管理规则</a></li>
	<?php  if($rid) { ?><li class="active"><a href="<?php  echo create_url('rule/post', array('id' => $rid))?>"><i class="icon-edit"></i> 编辑规则</a></li><?php  } ?>
	<li<?php  if(!$rid) { ?> class="active"<?php  } ?>><a href="<?php  echo create_url('rule/post', array('module' => $defaultmodule))?>"><i class="icon-plus"></i> 添加规则</a></li>
</ul>
<div class="main">
	<form class="form-horizontal form" action="" method="post" enctype="multipart/form-data" onsubmit="return formcheck(this)">
		<input type="hidden" name="id" value="<?php  echo $rule['rule']['id'];?>">
		<h4>添加规则 <small>删除，修改规则、关键字以及回复后，请提交规则以保存操作。</small></h4>
		<table class="tb">
			<tr>
				<th><label for="">规则名称</label></th>
				<td>
					<input type="text" id="rule-name" class="span6" placeholder="" name="name" value="<?php  if(empty($rule['rule']['name']) && !empty($_GPC['name'])) { ?><?php  echo $_GPC['name'];?><?php  } else { ?><?php  echo $rule['rule']['name'];?><?php  } ?>" /> &nbsp;
					<label for="adv-setting" class="checkbox inline">
						<input type="checkbox" id="adv-setting" hideclass="adv-setting"<?php  if($rule['rule']['displayorder'] > 0) { ?> checked='true'<?php  } ?>> 高级设置
					</label>
					<span class="help-block">您可以给这条规则起一个名字, 方便下次修改和查看.<a class="iconEmotion" href="javascript:;" inputid="rule-name"><i class="icon-github-alt"></i> 表情</a></span>
				</td>
			</tr>
			<tr class="hide adv-setting">
				<th><label for="">状态</label></th>
				<td>
					<label for="status_1" class="radio inline"><input type="radio" name="status" id="status_1" value="1" <?php  if($rule['rule']['status'] == 1 || empty($rule['rule']['status'])) { ?> checked="checked"<?php  } ?> /> 启用</label>
					<label for="status_0" class="radio inline"><input type="radio" name="status" id="status_0" value="0" <?php  if(!empty($rule) && $rule['rule']['status'] == 0) { ?> checked="checked"<?php  } ?> /> 禁用</label>
					<span class="help-block"></span>
				</td>
			</tr>
			<tr class="hide adv-setting">
				<th><label for="">是否置顶</label></th>
				<td>
					<label for="radio_1" class="radio inline"><input type="radio" name="istop" id="radio_1" onclick="$('#displayorder').hide();" value="1" <?php  if(!empty($rule['rule']['displayorder']) && $rule['rule']['displayorder'] == 255) { ?> checked="checked"<?php  } ?> /> 置顶</label>
					<label for="radio_0" class="radio inline"><input type="radio" name="istop" id="radio_0" onclick="$('#displayorder').show();$('#rule-displayorder').val(0)" value="0" <?php  if($rule['rule']['displayorder'] < 255) { ?> checked="checked"<?php  } ?> /> 普通</label>
					<span class="help-block">“置顶”时无论在什么情况下均能触发且使终保持最优先级，<span style="color:red">置顶设置过多，会影响系统效率，建议不要超过100个</span>；否则参考设置的“优先级”值</span>
				</td>
			</tr>
			<tr id="displayorder" class="hide adv-setting" <?php  if(!empty($rule['rule']['displayorder']) && $rule['rule']['displayorder'] == 255) { ?> style="display:none;"<?php  } ?>>
				<th><label for="">优先级</label></th>
				<td>
					<input type="text" id="rule-displayorder" class="span2" placeholder="" name="displayorder" value="<?php  echo $rule['rule']['displayorder'];?>">
					<span class="help-block">规则优先级，越大则越靠前，最大不得超过254</span>
				</td>
			</tr>
			<tr>
				<th><label for="">回复类型</label></th>
				<td>
					<?php  if(empty($rid)) { ?>
					<select name="module" id="module" class="span6" onchange="$(this).next().html($(this.options[this.selectedIndex]).attr('description'));buildModuleForm($(this).val())">
						<?php  if(is_array($modules)) { foreach($modules as $key => $mod) { ?>
						<option value="<?php  echo $mod['name'];?>" <?php  if($mod['name'] == $defaultmodule) { ?> selected="selected"<?php  } ?> description="<?php  echo $mod['description'];?>"><?php  echo $mod['title'];?></option>
						<?php  } } ?>
					</select>
					<span class="help-block" style="margin-top:0;"></span>
					<?php  } else { ?>
					<div class="span6 uneditable-input"><?php  echo $_W['modules'][$rule['rule']['module']]['title'];?></div>
					<span class="help-block" style="margin-top:0;"><?php  echo $_W['modules'][$rule['rule']['module']]['description'];?><input type="hidden" name="module" value="<?php  echo $rule['rule']['module'];?>" /></div>
					<?php  } ?>
				</td>
			</tr>
			<tr>
				<th><label for="">触发关键字</label></th>
				<td>
					<input type="text" class="span6" placeholder="" name="keywords" value="<?php  echo $rule['keywords'];?>" /> &nbsp;
					<label for="adv-keyword" class="checkbox inline">
						<input type="checkbox" id="adv-keyword" /> 高级触发
					</label>
					<span class="help-block">当用户的对话内容符合以上的关键字定义时，会触发这个回复定义。多个关键字请使用逗号隔开。</span>
				</td>
			</tr>
			<tr class="hide adv-keyword">
				<th><label for="">高级触发规则</label></th>
				<td>
					<div class="keyword-list list" id="keyword-list">
						<?php  if(is_array($rule['keyword'])) { foreach($rule['keyword'] as $item) { ?>
						<?php  if($item['type'] != '1') { ?>
						<div class="item" id="keyword-item-<?php  echo $item['id'];?>">
							<?php  include template('rule/item', TEMPLATE_INCLUDEPATH);?>
						</div>
						<?php  } ?>
						<?php  } } ?>
					</div>
					<a href="javascript:;" onclick="keywordHandler.buildForm()" class="add-kw-button"><i class="icon-plus"></i> 添加关键字</a>
				</td>
			</tr>
			<tr>
				<th><label for="">回复</label></th>
				<td>
					<div class="alert alert-block hide adv-setting">
						<div><span style="display:inline-block; width:150px; font-weight:600;">[from]</span>粉丝用户的OpenID</div>
						<div><span style="display:inline-block; width:150px; font-weight:600;">[to]</span>当前公众号的OpenID</div>
						<div><span style="display:inline-block; width:150px; font-weight:600;">[rule]</span>当前回复的回复编号</div>
					</div>
					<span class="help-block hide adv-setting" style="margin:5px 0;">可在回复内容的任何地方使用预定义标记来表示特定内容</span>
					<div id="module-form">
						<?php  if(!empty($rid)) { ?>
						<?php  $rule['reply']->fieldsFormDisplay($rule['rule']['id']);?>
						<?php  } else { ?>
						<?php  WeUtility::createModule($defaultmodule)->fieldsFormDisplay();?>
						</script>
						<?php  } ?>
					</div>
				</td>
			</tr>
			<tr>
				<th></th>
				<td>
					<button type="submit" class="btn btn-primary span3" name="submit" value="提交">提交</button>
					<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
				</td>
			</tr>
		</table>
	</form>
</div>
<script type="text/html" id="keyword-item-html">
<?php  unset($item); template('rule/item');?>
</script>
<script type="text/javascript">
<!--
	$(function(){
		$('#adv-keyword').click(function(){
			if(this.checked) {
				$('.adv-keyword').show();
			} else {
				$('.adv-keyword').hide();
			}
		});
	<?php  if($rule['kwd-adv']) { ?>
		$('#adv-keyword').attr('checked', 'checked');
		$('.adv-keyword').show();
	<?php  } ?>
	});
	var keywordHandler = {
		'buildForm' : function() {
			var obj = buildAddForm('keyword-item-html', $('#keyword-list'));
			obj.find('.btn-group .btn').on('click', function(){
				$(this).parent().next().html($(this).attr('description'));
				obj.find('#keyword-type-new').val($(this).attr('value'));
			});
			obj.find('#form').show();
			obj.find('#show').hide();
		},
		'doAdd' : function(itemid) {
			var parent = $('#' + itemid);
			if ($('.keyword-name-new', parent).val() == '' && $('.keyword-type-new', parent).val() != 4) {
				message('请输入关键字！', '', 'error');
				return false;
			}
			if($('.keyword-type-new', parent).val() == 4) {
				$('.keyword-name-new', parent).val('');
			}
			var typetips = $('.active', parent).html();
			$('#show #type', parent).html(typetips);
			$('#show #content', parent).html($('.keyword-name-new', parent).val());
			$('#show', parent).css('display', 'block');
			$('#form', parent).css('display', 'none');
		},
		'doEditItem' : function(itemid) {
			$('#keyword-list .item').each(function(){
				$('#form', $(this)).css('display', 'none');
				$('#show', $(this)).css('display', 'block');
			});
			doEditItem(itemid);
		}
	};

	function buildModuleForm(module) {
		try {
			$.ajax({
			  url: "<?php  echo create_url('member/module', array('do' => 'form', 'id' => $rule['rule']['id']))?>",
			  type: "GET",
			  data: {'name' : module.toLowerCase()},
			  dataType: "html"
			}).done(function(s) {
				if (s && s.indexOf('"type":"error"') >= 0) {
					message('请重新选择公众号！', '<?php  echo create_url('rule/post')?>', 'error');
					return false;
				}
				if (s && s.indexOf('already:') >= 0) {
					s = s.replace(/already:/g, '');
					message('这个模块属于单规则模块, 规则已经存在！', '<?php  echo create_url('rule/post')?>' + '&id=' + s, 'error');
					return false;
				}

				$('#module-form').html(s);
			});
		}
		catch (e) {
		}
	}

	function formcheck(form) {
		if (form['name'].value == '') {
			message('抱歉，规则名称为必填项，请返回修改！', '', 'error');
			return false;
		}
		if ($(':text[name="keywords"]').val() == '' && $('.keyword-name-new').val() == '' && $('.keyword-type-new').val() != '4') {
			message('抱歉，您至少要设置一个触发关键字！', '', 'error');
			return false;
		}
		$(':text[name="keywords"]').val($(':text[name="keywords"]').val().replace(/，/g, ','));
		return true;
	}

	<?php  if(empty($rid)) { ?>
	$(function(){
		keywordHandler.buildForm();
	});
	<?php  } else { ?>
	$('.btn-group .btn').on('click', function(){
		$(this).parent().next().html($(this).attr('description'));
		$(this).parent().parent().find('#keyword-type-new').val($(this).attr('value'));
	});
	<?php  } ?>

//-->
</script>
<?php  include template('common/footer', TEMPLATE_INCLUDEPATH);?>
