<?php
if (!class_exists('Rollbar')) {
	App::import('Vendor', 'Rollbar.Rollbar', array('file' => 'rollbar.php'));
}
class RollbarClient {

	protected static $_Instance;

	protected $_Notifier;

	protected $_defaultOptions = array(
		'access_token' => '',
		'environment' => 'production',
		'root' => '',
		'max_errno' => -1
	);

	protected function __construct() {
		$options = array_merge($this->_defaultOptions, (array) Configure::read('Rollbar'));
		Rollbar::init($options, false, false);
		$this->_Notifier = Rollbar::$instance;
	}

	protected function __clone() {
	}

	public static function getInstance() {
		if (!isset(static::$_Instance)) {
			static::$_Instance = new self();
		}
		return static::$_Instance;
	}

	public static function reportException(Exception $exception) {
		return static::getInstance()->_Notifier->report_exception($exception);
	}

	public static function reportError($errno, $errstr, $errfile, $errline) {
		return static::getInstance()->_Notifier->report_php_error($errno, $errstr, $errfile, $errline);
	}

	public static function reportMessage($message, $level = 'error', $extraData = null) {
		return static::getInstance()->_Notifier->report_message($message, $level, $extraData);
	}

}