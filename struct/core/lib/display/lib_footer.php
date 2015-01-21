<?php //$id lib_footer.php


class lib_footer extends template {
	private static $instance = false;
	private $footer = 'footer.tpl.php';
	
	public function __construct() {
	}
	/**
	 * 设置尾部模板文件名
	 *
	 * @param unknown_type $footername
	 */
	public function setFooter($footername = NULL) {
		if ($footername) {
			$this->footer = $footername;
		}
		parent::__construct ( $this->footer );
	}
	
	public static function instance() {
		if (! self::$instance) {
			self::$instance = new lib_footer ();
		}
		
		return self::$instance;
	}
}

?>