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
    	
        $themes = self::get_themes();
        $live2d_themes = new Typecho_Widget_Helper_Form_Element_Select('live2d_themes',$themes,null,_t('选择默认模型包'));
        $form->addInput($live2d_themes);
		//工具栏
		$live2d_canTurnToHomePage = new Typecho_Widget_Helper_Form_Element_Checkbox('live2d_canTurnToHomePage',['显示返回首页按钮'],'0',_t('工具栏详细设定'));
	    $form->addInput($live2d_canTurnToHomePage);
	    $live2d_canSwitchHitokoto = new Typecho_Widget_Helper_Form_Element_Checkbox('live2d_canSwitchHitokoto',['显示一言切换按钮'],'0');
	    $form->addInput($live2d_canSwitchHitokoto);
		$live2d_canSwitchModel = new Typecho_Widget_Helper_Form_Element_Checkbox('live2d_canSwitchModel',['显示模型切换按钮'],'0');
		$form->addInput($live2d_canSwitchModel);
		$live2d_canSwitchTextures = new Typecho_Widget_Helper_Form_Element_Checkbox('live2d_canSwitchTextures',['显示材质切换按钮'],'0');
       	$form->addInput($live2d_canSwitchTextures);
		$live2d_canTakeScreenshot = new Typecho_Widget_Helper_Form_Element_Checkbox('live2d_canTakeScreenshot',['显示看板娘截图按钮'],'0');
		$form->addInput($live2d_canTakeScreenshot);
		$live2d_canTurnToAboutPage = new Typecho_Widget_Helper_Form_Element_Checkbox('live2d_canTurnToAboutPage',['显示关于按钮'],'0');
		$form->addInput($live2d_canTurnToAboutPage);
		$live2d_canCloseLive2d = new Typecho_Widget_Helper_Form_Element_Checkbox('live2d_canCloseLive2d',['显示关闭按钮'],'0');
		$form->addInput($live2d_canCloseLive2d);
		
		//模型切换模式
		// 是否开启时间小贴士
        $live2d_modelStorage = new Typecho_Widget_Helper_Form_Element_Radio('live2d_modelStorage',
            array(
             'true' => _t('恢复'),
             'false' => _t('不恢复'),
            
            ),
            'true', _t('模型切换，刷新后是否恢复'));
		$form->addInput($live2d_modelStorage);
		$live2d_modelRandMode = new Typecho_Widget_Helper_Form_Element_Radio('live2d_modelRandMode',
            array(
              'rand' => _t('随机'),
              'switch' => _t('顺序'),
            ),
            'rand', _t('模型切换模式'));
		$form->addInput($live2d_modelRandMode);
		$live2d_modelTexturesRandMode = new Typecho_Widget_Helper_Form_Element_Radio('live2d_modelTexturesRandMode',
            array(
              'rand' => _t('随机'),
              'switch' => _t('顺序'),
            ),
            'rand', _t('材质切换模式'));
		$form->addInput($live2d_modelTexturesRandMode);
		
		//提示消息选项
		$live2d_showHitokoto = new  Typecho_Widget_Helper_Form_Element_Checkbox('live2d_showHitokoto',['显示一言'],'0',_t('提示消息选项'));
		$form->addInput($live2d_showHitokoto);
		$live2d_showF12Status = new Typecho_Widget_Helper_Form_Element_Checkbox('live2d_showF12Status',['显示加载状态'],'0');
		$form->addInput($live2d_showF12Status);
		$live2d_showF12Message = new Typecho_Widget_Helper_Form_Element_Checkbox('live2d_showF12Message',['显示看板娘消息'],'0'); 
		$form->addInput($live2d_showF12Message);
		$live2d_showF12OpenMsg = new Typecho_Widget_Helper_Form_Element_Checkbox('live2d_showF12OpenMsg',['显示控制台打开提示'],'0'); 
		$form->addInput($live2d_showF12OpenMsg);
		$live2d_showCopyMessage = new Typecho_Widget_Helper_Form_Element_Checkbox('live2d_showCopyMessage',['显示复制内容提示'],'0');
		$form->addInput($live2d_showCopyMessage);
		$live2d_showWelcomeMessage = new Typecho_Widget_Helper_Form_Element_Checkbox('live2d_showWelcomeMessage',['显示进入面页欢迎词'],'0');
		$form->addInput($live2d_showWelcomeMessage);
		
		//看板娘样式设置
		$live2d_waifuSize = new Typecho_Widget_Helper_Form_Element_Text('live2d_waifuSize', NULL, '280x250', _t('自定义看板娘大小'), _t('在这里填入自定义大小，格式如：280x250'));
		$form->addInput($live2d_waifuSize);
		$live2d_waifuTipsSize = new Typecho_Widget_Helper_Form_Element_Text('live2d_waifuTipsSize', NULL, '250x70', _t('自定义提示框大小'), _t('在这里填入自定义大小，格式如：250x70'));
		$form->addInput($live2d_waifuTipsSize);
		$live2d_waifuFontSize = new Typecho_Widget_Helper_Form_Element_Text('live2d_waifuFontSize', NULL, '12px', _t('提示框字体大小'), _t('在这里填入提示框字体大小，格式如：12px'));
		$form->addInput($live2d_waifuFontSize);
		$live2d_waifuToolFont = new Typecho_Widget_Helper_Form_Element_Text('live2d_waifuToolFont', NULL, '14px', _t('工具栏字体大小'), _t('在这里填入工具栏字体大小，格式如：14px'));
		$form->addInput($live2d_waifuToolFont);
		$live2d_waifuToolLine = new Typecho_Widget_Helper_Form_Element_Text('live2d_waifuToolLine', NULL, '20px', _t('工具栏行高'), _t('在这里填入工具栏行高，格式如：20px'));
		$form->addInput($live2d_waifuToolLine);
		$live2d_waifuToolTop = new Typecho_Widget_Helper_Form_Element_Text('live2d_waifuToolTop', NULL, '0px', _t('工具栏顶部边距'), _t('在这里填入工具栏顶部边距，格式如：0px'));
		$form->addInput($live2d_waifuToolTop);
		$live2d_waifuMinWidth = new Typecho_Widget_Helper_Form_Element_Text('live2d_waifuMinWidth', NULL, '768px', _t('面页小于指定宽度隐藏看板娘'), _t('面页小于 指定宽度 隐藏看板娘，例如 :disable(禁用), 768px'));
		$form->addInput($live2d_waifuMinWidth);
		$live2d_waifuEdgeSide = new Typecho_Widget_Helper_Form_Element_Text('live2d_waifuEdgeSide', NULL, 'right:0', _t('看板娘贴边方向'), _t('看板娘贴边方向，例如 :left:0(靠左 0px), right:30(靠右 30px)'));
		$form->addInput($live2d_waifuEdgeSide);
		
		$live2d_waifuDraggable = new Typecho_Widget_Helper_Form_Element_Radio('live2d_waifuDraggable',
            array(
              'disable' => _t('禁用'),
              'axis-x' => _t('水平'),
              'unlimited' => _t('自由'),
            ),
            'disable', _t('拖拽样式'));
		$form->addInput($live2d_waifuDraggable);
		$live2d_waifuDraggableRevert = new Typecho_Widget_Helper_Form_Element_Radio('live2d_waifuDraggableRevert',
            array(
              'true' => _t('还原'),
              'false' => _t('不还原'),
            ),
            'false', _t('松开鼠标还原拖拽位置'));
		$form->addInput($live2d_waifuDraggableRevert);
		//self::get_config();
		
		
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
        self::get_themes();
		
    }

    //配置修改
    private static function live2d_setting($path){
        $themes_index = Typecho_Widget::widget('Widget_Options')->Plugin('Live2d')->live2d_themes;
        $themes_list = self::get_themes();
        $themes_path = $path.'/Live2d/themes/';
        $json = json_encode($themes_list);
        $live2d_themes= urldecode($json);
		$live2d_config = self::get_config($themes_path.$themes_list[$themes_index]);
        $script = <<<eof
live2d_settings['modelAPI'] = '{$themes_path}';
localStorage.live2d_themes = {$live2d_themes};
{$live2d_config}
localStorage.live2d_model_id = {$themes_index};
  initModel("{$path}/Live2d/assets/waifu-tips.json")
eof;
        echo "<script type='text/javascript'>".$script."</script>";
    }

    //遍历插件下模型文件
    private static function get_themes(){
        $ppd = Helper::options()->pluginDir('Live2d');
        $path = $ppd.'/Live2d/themes';
        //插件目录下的live2d素材包
        $list = scandir($path);
        //去除头部文件夹
        unset($list[0]);
        unset($list[1]);
        //重建数组索引
        sort($list);
        return $list;


    }

	//获取用户设置
	private static function get_config($theme_path){
		$config = Typecho_Widget::widget('Widget_Options')->Plugin('Live2d');
		//用户设置选项
		$config_option_arr = ['canTurnToHomePage','canSwitchHitokoto','canSwitchModel','canSwitchTextures','canTakeScreenshot','canTurnToAboutPage','canCloseLive2d','modelStorage','modelRandMode','modelTexturesRandMode','showHitokoto','showF12Status','showF12Message','showF12OpenMsg','showCopyMessage','showWelcomeMessage','waifuSize','waifuTipsSize','waifuFontSize','waifuToolFont','waifuToolLine','waifuToolTop','waifuMinWidth','waifuEdgeSide','waifuDraggable','waifuDraggableRevert'];
		//获取设置选项
		$web_config = '';
		foreach($config_option_arr as $key=>$val){
			$option = 'live2d_'.$val;
			$live2d_option = $config->$option;
			
			if(is_array($live2d_option) || $live2d_option===0 || $live2d_option == 'true'){
				$live2d_option = 1;
			}
			if(is_null($live2d_option) || $live2d_option =='false'){
				$live2d_option = 0;
			}
			
		
			
			if(is_numeric($live2d_option)){
				$web_config .='live2d_settings[\''.$val.'\'] = '.$live2d_option.';'; 
			}else{
				$web_config .='live2d_settings[\''.$val.'\'] = \''.$live2d_option.'\';'; 
			}
			
		}
		//生成页面配置
		return $web_config;
	}

   
}
