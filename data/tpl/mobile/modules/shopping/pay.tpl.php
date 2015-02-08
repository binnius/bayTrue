<?php defined('IN_IA') or exit('Access Denied');?><?php  $bootstrap_type = 3;?>
<?php  include $this->template('header', TEMPLATE_INCLUDEPATH);?>
<?php  $this->pay($params);?>
<?php  include $this->template('footerbar', TEMPLATE_INCLUDEPATH);?>