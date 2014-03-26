<?php
Configure::write('Rollbar', array(
	'access_token' => 'YourAccessTokenHere',
	'environment' => (env('ENVIRONMENT') === 'development') ? 'development' : 'production',
	'root' => ROOT,
	'handler' => 'agent', // Can be 'agent' or 'blocking'. 'agent' requires https://github.com/rollbar/rollbar-agent to be installed on server
	'agent_log_location' => TMP . 'rollbar' . DS,
	'max_errno' => -1
));

/* Set error handlers */
App::uses('RollbarErrorHandler', 'Rollbar.Lib');
App::uses('RollbarConsoleErrorHandler', 'Rollbar.Lib');

$consoleHandler = new RollbarConsoleErrorHandler();

Configure::write('Error.handler', 'RollbarErrorHandler::handleError');
Configure::write('Error.consoleHandler', array($consoleHandler, 'handleError'));

Configure::write('Exception.handler', 'RollbarErrorHandler::handleException');
Configure::write('Exception.consoleHandler', array($consoleHandler, 'handleException'));