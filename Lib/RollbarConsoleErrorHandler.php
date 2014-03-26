<?php
App::import('Lib', 'Rollbar.RollbarClient');
App::uses('ConsoleErrorHandler', 'Console');
class RollbarConsoleErrorHandler extends ConsoleErrorHandler {

	public function handleError($code, $description, $file = null, $line = null, $context = null) {
		if (error_reporting() === 0) {
			return false;
		}
		RollbarClient::reportError($code, $description, $file, $line);
		return parent::handleError($code, $description, $file, $line, $context);
	}

	public function handleException(Exception $exception) {
		if ($exception->getCode() !== 404) {
			RollbarClient::reportException($exception);
		}
		return parent::handleException($exception);
	}

}