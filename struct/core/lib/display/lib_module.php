<?php //$id lib_module.php
class lib_module extends template {
	private static $instance = false;
	private $JSElements;
	private $CSSElements;
	private $modulePath = 'index.tpl.php';
	
	public function __construct($modulePath = null) {
		$this->JSElements = array();
		$this->CSSElements = array();
		if(!!$modulePath){
			$this->setModule($modulePath);
		}
	}
	
	public function addJavaScript($scriptPath) {
		$script = "<script type=\"text/javascript\" src=\"" . $scriptPath . "\"></script>";
		$this->JSElements[] = $script ;
	}
	
	public function addJavascriptCode($script) {
		if (false === strpos ( $script, '<script' )) {
			$script = "<script type=\"text/javascript\">\n{$script}\n</script>";
		}
		
		$this->JSElements[] = $script;
	}
	
	public function addCSS($cssPath) {
		$css = "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$cssPath}\">";
		$this->CSSElements[] =  $css;
	}
	
	public function setModule($modulePath) {
		$this->modulePath = $modulePath;
		parent::__construct ( $this->modulePath );
	}
	
	public function setView($params) {
		$this->assign ( 'Views', $params );
	}
	
	public function render() {
		
		$headHTMLStr = '';
		
		if(count($this->CSSElements)>0){
			$headHTMLStr .= implode('',$this->CSSElements);
		}
		if(count($this->JSElements)>0){
			$headHTMLStr .= implode('',$this->JSElements);
		}
		$this->assign ( 'headElement', $headHTMLStr );
		return parent::render ();
	}
	
	public static function instance() {
		if (! self::$instance) {
			self::$instance = new lib_module ();
		}
		
		return self::$instance;
	}
}
?>