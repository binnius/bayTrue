<?php defined('IN_IA') or exit('Access Denied');?><?php  include $this->template('common/header', TEMPLATE_INCLUDEPATH);?>
 <ul class="nav nav-tabs">
	<li><a href="<?php  echo $this->createWebUrl('shopset')?>">基本设置</a></li>
	<li><a href="<?php  echo $this->createWebUrl('mailset')?>">邮件设置</a></li>	
	<li><a href="<?php  echo $this->createWebUrl('printset')?>">打印机设置</a></li>	
	<li  class="active"><a href="<?php  echo $this->createWebUrl('smsset')?>">短信设置</a></li>	
	<li><a href="<?php  echo $this->createWebUrl('orderset')?>">订单限制</a></li>	
	<li><a href="<?php  echo $this->createWebUrl('ordertype')?>">店铺类型</a></li>	
</ul>

<div class="main">
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
	<input type="hidden" name="parentid" value="<?php  echo $set['id'];?>" />
		<h4>短信平台基本设置 <small>短信账号和密码请联系管理员开通</small></h4>
		<table class="tb">
			<tr>
				<th><label for="">订单发送开启</label></th>
				<td>
					<label for="isshow1" class="radio inline"><input type="radio" name="sms_status" value="1" id="isshow1" <?php  if($set['sms_status']==1) { ?>checked="true"<?php  } ?> /> 是</label>
					&nbsp;&nbsp;&nbsp;
					<label for="isshow2" class="radio inline"><input type="radio" name="sms_status" value="0" id="isshow2"  <?php  if($set['sms_status']==0) { ?>checked="true"<?php  } ?> /> 否</label>
					<span class="help-block">是否开启短信提醒客户.</span>
				</td>
			</tr>
			<tr>
				<th><label for="">注册短信验证</label></th>
				<td>
					<label for="sms_resgister1" class="radio inline"><input type="radio" name="sms_resgister" value="1" id="sms_resgister1" <?php  if($set['sms_resgister']==1) { ?>checked="true"<?php  } ?> /> 开启</label>
					&nbsp;&nbsp;&nbsp;
					<label for="sms_resgister2" class="radio inline"><input type="radio" name="sms_resgister" value="0" id="sms_resgister2"  <?php  if($set['sms_resgister']==0) { ?>checked="true"<?php  } ?> /> 关闭</label>
					<span class="help-block">首次下单短信验证</span>
				</td>
			</tr>
			<!--tr>
				<th><label for="">发送类型</label></th>
				<td>
					<label for="sms_type1" class="radio inline"><input type="radio" name="sms_type" value="0" id="sms_type1" <?php  if($set['sms_type']==0) { ?>checked="true"<?php  } ?>/>发送给商家</label>
					&nbsp;&nbsp;&nbsp;
					<label for="sms_type2" class="radio inline"><input type="radio" name="sms_type" value="1" id="sms_type2"  <?php  if($set['sms_type']==1) { ?>checked="true"<?php  } ?>/>发送给客户</label>
					&nbsp;&nbsp;&nbsp;
					<label for="sms_type3" class="radio inline"><input type="radio" name="sms_type" value="2" id="sms_type3"  <?php  if($set['sms_type']==2) { ?>checked="true"<?php  } ?>/>两者都发送</label>
					<span class="help-block">如果选择了打印机发送的方式，则只能发送商家或者客户</span>
				</td>
			</tr>			
			<tr>
				<th><label for="">商家手机号</label></th>
				<td>
					<input type="text" name="sms_phone" class="span6" value="<?php  echo $set['sms_phone'];?>" />
					<p class="help-block">目前暂时支持1个用户，请正确输入11位手机号</p>					
				</td>
			</tr>
			<tr>
				<th><label for="">发送方法</label></th>
				<td>
					<label for="sms_from1" class="radio inline"><input type="radio" name="sms_from" value="1" id="sms_from1" <?php  if($set['sms_from']==1) { ?>checked="true"<?php  } ?>/>打印机发送</label>
					&nbsp;&nbsp;&nbsp;
					<label for="sms_from2" class="radio inline"><input type="radio" name="sms_from" value="2" id="sms_from2"  <?php  if($set['sms_from']==2) { ?>checked="true"<?php  } ?>/>短信平台发送</label>
  					<span class="help-block">如果选择了打印机发送的方式，则只能发送商家或者客户</span>
				</td>
			</tr -->
			<tbody id="api">
			<tr>
				<th><label for="">短信平台用户</label></th>
				<td>
					<input type="text" name="sms_user" class="span6" value="<?php  echo $set['sms_user'];?>" />
					<p class="help-block">短信平台用户名</p>					
				</td>
			</tr>
 			<tr>
				<th><label for="">短信平台密码</label></th>
				<td>
					<input type="password" name="sms_secret" class="span6" value="<?php  echo $set['sms_secret'];?>" />
					<p class="help-block">短信平台密匙，用户API发送短信</p>					
				</td>
			</tr>
			</tbody>
			<!--tr>
				<th>短信模板</th>
				<td>
					<textarea style="height:100px;" class="span7" name="sms_text" cols="70"><?php  echo $set['sms_text'];?></textarea>
					<p class="help-block">发送短信模板，[date]时间，[totalnum]总数量,[totalprice]总价格，建议短信字数不超过70字。</p>					
				</td>
			</tr-->
			<?php  if(!empty($msm['content'])) { ?>
			<tr>
				<th>短信账户</th>
				<td><?php  if(empty($msg)) { ?>已发送数量：<?php  echo intval($msm_arr['0'])?>条,账户剩余短信数量:<?php  echo intval($msm_arr['1'])?>条。
					<?php  } else { ?><?php  echo $msg;?>
					<?php  } ?>					
				</td>
			</tr>
			<?php  } ?>
			<tr>
				<th></th>
				<td>
					<input name="submit" type="submit" value="提交" class="btn btn-primary span3">
					<input type="hidden" name="id" value="<?php  echo $set['id'];?>" />
					<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
 
				</td>
			</tr>
		</table>
	</form>
</div>
<script type="text/javascript">
$(':radio[name="sms_from"]').click(function() {
	tt=$(this).val();
	if(tt==2){
		$("#api").show();
	}else{
		$("#api").hide();
	}
});
</script>	
<?php  include $this->template('common/footer', TEMPLATE_INCLUDEPATH);?>