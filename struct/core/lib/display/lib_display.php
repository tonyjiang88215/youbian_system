<?php //$id lib_display.php
/**
 * 
 */
include_once dirname(__FILE__).'/interface/i_display.php';
include_once dirname(__FILE__).'/lib_template.php';
include_once dirname(__FILE__).'/lib_module.php';
include_once dirname(__FILE__).'/lib_header.php';
include_once dirname(__FILE__).'/lib_body.php';
include_once dirname(__FILE__).'/lib_footer.php';

class lib_display implements display {
	public $header, $body, $footer;
	
	public function __construct() {
		$this->header = lib_header::instance ();
		$this->body = lib_body::instance ();
		$this->footer = lib_footer::instance ();
	}
	
	/**
	 * 设置页面title
	 * @param unknown_type $title
	 */
	public function setTitle($title) {
		$this->header->setTitle ( $title );
	}
	
	/**
	 * 输入需要显示的数据；
	 * @param array $params
	 */
	public function setView($params) {
		$this->body->setView ( $params );
	}
	
	
	public function addModule($moduleName , $moduleTpl = null , $moduleData = null){
		if(!$moduleTpl){
			$moduleTpl = $moduleName.'.module.php';
		}
		$this->body->addModule($moduleName , $moduleTpl , $moduleData);
	}
	
	public function addModuleObject($moduleName , $moduleObject){
		$this->body->addModuleObject($moduleName , $moduleObject);
	}
	
	/**
	 * 选择需要显示的模板页面名称
	 * @param string $element
	 */
	public function setBody($element) {
		/*if(substr($element,-8) != '.tpl.php'){
			$element .= '.tpl.php'; 
		}*/
		$this->body->setBody ( $element );
	}
	
	/**
	 * 输出
	 */
	public function render() {
		try {
			$this->header->sendHttpHeader ();
			$output = '';
			$output .= $this->header->render ();
			$output .= $this->body->render ();
			$output .= $this->footer->render ();
			
			echo $output;
		} catch ( Exception $e ) {
//			factory::debug ( $e->__toString () . "\n" . $e->getMessage () );
			echo $e->getMessage();
			exit;
		}
	}
}
?>