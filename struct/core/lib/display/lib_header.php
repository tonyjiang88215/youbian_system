<?php //$id lib_header.php
/**
 * 
 */
class lib_header extends template {
	private $_htmlHeaders;
	private $_httpHeaders;
	private $title;
	private $header = 'header.tpl.php';
	
	private static $instance = false;
	
	public function __construct() {
		$this->_htmlHeaders = array ();
		$this->_httpHeaders = array ();
	}
	/**
	 * 设置头文件名
	 *
	 * @param unknown_type $headername
	 */
	public function setHeader($headername = NULL) {
		if ($headername) {
			$this->header = $headername;
		}
		parent::__construct ( $this->header );
	}
	
	/**
	 * 向页面Head增加html头元素
	 *
	 * @param  $html
	 */
	public function addHtmlHeader($html) {
		$this->_htmlHeaders [] = $html;
	}
	/**
	 * 向页面Head增加http头元素
	 *
	 * @param $http
	 */
	public function addHttpHeader($http) {
		$this->_httpHeaders [] = $http;
	}
	/**
	 * 向页面Head增加javascript文件
	 *
	 * @param  $scriptPath
	 */
	public function addJavaScript($scriptPath) {
		$script = "<script type=\"text/javascript\" src=\"" . $scriptPath . "\"></script>";
		$this->addHtmlHeader ( $script );
	}
	/**
	 * 向head添加Javascript代码
	 *
	 * @param unknown_type $script
	 */
	public function addJavascriptCode($script) {
		if (false === strpos ( $script, '<script' )) {
			$script = "<script type=\"text/javascript\">\n{$script}\n</script>";
		}
		
		$this->addHtmlHeader ( $script );
	}
	/**
	 * 向页面Head增加CSS
	 *
	 * @param $cssPath
	 */
	public function addCSS($cssPath) {
		$css = "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$cssPath}\">";
		$this->addHtmlHeader ( $css );
	}
    /**
	 * 向页面Head增加IE6兼容判断CSS
	 *
	 * @param $cssPath
	 */
	public function addIE6CSS($cssPath)
	{
		$css = "<!--[if IE 6]><link rel=\"stylesheet\" type=\"text/css\" href=\"{$cssPath}\"><![endif]-->";
		$this->addHtmlHeader($css);
	}
	/**
	 * 设置title
	 *
	 * @param unknown_type $title
	 */
	public function setTitle($title) {
		$this->title = $title;
	}
	
	public function setView($params) {
		$this->assign ( 'Views', $params );
	}
	
	/**
	 * 发送http头
	 *
	 */
	public function sendHttpHeader() {
		if (count ( $this->_httpHeaders ) > 0) {
			foreach ( $this->_httpHeaders as $httpHeader ) {
				header ( $httpHeader );
			}
		}
	}
	/**
	 * 渲染
	 *
	 * @return unknown
	 */
	public function render() {
		$pageTitle = '';
		if (! empty ( $this->title )) {
			$pageTitle .= $this->title;
		}
		
		$pageTitle .= "-华夏资源管理中心";
		$this->assign ( 'pageTitle', $pageTitle );
		$htmlHeaderStr = '';
		$htmlHeaderStr = implode ( "\n", $this->_htmlHeaders );
		$this->assign ( 'headerTagElement', $htmlHeaderStr );
		return parent::render ();
	}
	/**
	 * 初始化单例
	 *
	 * @return unknown
	 */
	public static function instance() {
		if (! self::$instance) {
			self::$instance = new lib_header ();
		}
		
		return self::$instance;
	}

}
?>