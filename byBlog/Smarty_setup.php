<?php
require_once( 'smarty/libs/Smarty.class.php');
class Smarty_setup extends Smarty {
    function __construct(){
        $this->setTemplateDir('smarty/templates/');
        $this->setCompileDir('smarty/templates_c/');
        $this->setConfigDir('smarty/configs/');
        $this->setCacheDir('smarty/cache/');

        //	$this->caching = Smarty::CACHING_LIFETIME_CURRENT;
        $this->clearAllCache();//清除所有缓存
        $this->assign('app_name', 'blog');
    }
}
?>