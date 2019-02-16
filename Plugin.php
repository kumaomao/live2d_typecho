<?php
/**
 * Live2d_看板娘
 *
 * @package Live2d_看板娘
 * @author kumaomao
 * @version 1.0.0
 * @link
 */

class Live2d_Plugin implements Typecho_Plugin_Interface
{

    public static function activate()
    {
        Typecho_Plugin::factory('Widget_Archive')->footer=array('Live2d_Plugin', 'footer');
        Typecho_Plugin::factory('Widget_Archive')->header = array('Live2d_Plugin', 'header');
        // TODO: Implement activate() method.
    }

    public static function config(Typecho_Widget_Helper_Form $form)
    {
        $custom_model = new Typecho_Widget_Helper_Form_Element_Text('custom_model', NULL, NULL, _t('自定义配置文件地址'), _t('在这里填入一个模型 JSON 配置文件地址，可供更换模型，不填则使用默认配置文件'));
        $form->addInput($custom_model);
    }

    public static function deactivate()
    {
        // TODO: Implement deactivate() method.
    }

    public static function personalConfig(Typecho_Widget_Helper_Form $form)
    {
        // TODO: Implement personalConfig() method.
    }

    //向文件写入看板娘组件
    public  static function footer(){
        $ppd = Helper::options()->pluginUrl;
        $div = <<<eof
<div class="waifu" style="z-index: 100;">
	      <div class="waifu-tips"></div>
	      <canvas id="live2d" class="live2d"></canvas>
	      <div class="waifu-tool">
	          <span class="fui-home"></span>
	          <span class="fui-chat"></span>
	          <span class="fui-eye"></span>
	          <span class="fui-user"></span>
	          <span class="fui-photo"></span>
	          <span class="fui-info-circle"></span>
	          <span class="fui-cross"></span>
	      </div>
	  </div>
eof;
        echo $div;

        echo "<script>!window.jQuery && document.write(\"";
        echo "<script src='".$ppd."/Live2d/assets/jquery.js'><\/script>";
        echo "\")</script>";

        echo "<script src='".$ppd."/Live2d/assets/waifu-tips.js'></script> \n";
        echo "<script src='".$ppd."/Live2d/assets/live2d.js'></script> \n";

        //看板娘配置
        self::live2d_setting($ppd);
    }

    //加入css
    public static function header(){
        $ppd = Helper::options()->pluginUrl;
        echo "<link rel='stylesheet' href='".$ppd."/Live2d/assets/waifu.css' />";
    }

    //配置修改
    private static function live2d_setting($path){
        $script = <<<eof
live2d_settings['modelAPI'] = '{$path}/Live2d/themes/xxb/model.json';
 live2d_settings['waifuSize'] = '360x400';
  initModel("{$path}/Live2d/assets/waifu-tips.json")
eof;

        echo "<script type='text/javascript'>".$script."</script>";


    }
}