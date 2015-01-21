<?php //$id lib_body.php
class lib_body extends template {
	private static $instance = false;
	private $bodyPath = 'index.tpl.php';
	
	public function __construct() {
	
	}
	
	public function setBody($bodyPath) {
		$this->bodyPath = $bodyPath;
		parent::__construct ( $this->bodyPath );
	}
	
	public function setView($params) {
		$this->assign ( 'Views', $params );
	}
	
	public function render() {
		return parent::render ();
	}
	
	public static function instance() {
		if (! self::$instance) {
			self::$instance = new lib_body ();
		}
		
		return self::$instance;
	}
}
?>