<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

/**
 * 游客止步，后台所有界面不允许进入，需要管理员在前台登录后才允许进入后台页面；同时附件页面不允许非管理员用户访问！
 * 
 * @package 游客止步
 * @author 张老师
 * @version 1.6
 * @link https://qqdie.com/archives/stop-plugin-typecho.html
 */
class stop_Plugin implements Typecho_Plugin_Interface
{

    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        Typecho_Plugin::factory('admin/common.php')->begin = array('stop_Plugin', 's');
        Typecho_Plugin::factory('Widget_Logout')->logout = array('stop_Plugin', 'm');
        Typecho_Plugin::factory('Widget_Archive')->header = array('stop_Plugin', 'header');
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @statics
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){}

    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {
    }

    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form)
    {}

    public static function s()
    {
Typecho_Widget::widget('Widget_User')->to($user);
Typecho_Widget::widget('Widget_Options')->to($options);
if(!$user->pass('editor', true)){
header("HTTP/1.0 404 Not Found");
header("Status: 404 Not Found");
exit;
}
    }
public static function m(){
$url = Helper::options()->siteUrl;
Header("Location:$url"); 
@session_destroy();
 exit;
}

public static function header($h, $obj){
$txt=$h;
if($obj->is('attachment')){
Typecho_Widget::widget('Widget_User')->to($user);
Typecho_Widget::widget('Widget_Options')->to($options);
if(!$user->pass('editor', true)){
$url = Helper::options()->siteUrl;
Header("Location:$url"); 
@session_destroy();
 exit;
}
}
return $txt;
}



}
