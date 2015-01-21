<?php //$id template.lib.php
/**
 * @copyright 
 * @version 
 * @author Tony<yanglin21@yeah.net>
 */
/**
 * 模板基类
 */
include_once dirname(__FILE__).'/lib_display_setting.php';

class template implements display {
	protected $_templatePath;
	
	protected $modules = array();
	
	public function __construct($path) {
		$this->_templatePath = DISPLAY_TEMPLATE_DIR_PATH .'/'. $path;
	}
	
	/*命名
	 * 
	 */
	protected function assign($name, $value) {
		$this->$name = $value;
	}
	
	public function addModule($paramName , $moduleName , $moduleData = null){
		$this->modules[$paramName] = array('tpl'=>$moduleName , 'data'=>$moduleData);
	}
	
	public function addModuleObject($paramName , $moduleObject){
		$this->modules[$paramName] = $moduleObject;
	}
	
	
	public function render() {
		global $CFG;
		foreach($this->modules as $moduleName => $module){//制作每一个模块的HTML，并且进行定义
			if($module){
				if($module instanceof lib_module){//如果是module对象
					$moduleObject = $module;
				}else if(gettype($module['data']) == 'string' && strpos($module['data'],'.php')!=-1){//如果是指定的数据文件
					include_once DISPLAY_TEMPLATE_MODULE_DATA_PATH.'/'.$module['data'];
					$moduleObject = new self($module['tpl']);
// 					print_r($Views);
					$moduleObject->assign('Views',$Views);
					
				}else{
					$moduleObject = new self($module['tpl']);
					$moduleObject->assign('Views',$module['data']);
				}
			}
			$$moduleName = $moduleObject->render();
		}
		if (! empty ( $this->Views ) && is_array ( $this->Views )) {
			extract ( $this->Views, EXTR_OVERWRITE );
		}
// 		echo $this->_templatePath.'<br />';
		if (file_exists ( $this->_templatePath )) {
			ob_start ();
			include ($this->_templatePath);
			$render = ob_get_contents ();
			ob_end_clean ();
			return $render;
		} else {
			throw new Exception ( '找不到模板文件' . $this->_templatePath );
		}
	}
}
?>