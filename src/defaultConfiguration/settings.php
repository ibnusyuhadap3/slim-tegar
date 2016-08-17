<?php
use function DI\get;

return [
	// Settings that can be customized by users
    'settings.httpVersion' => '1.1',
    'settings.responseChunkSize' => 4096,
    'settings.outputBuffering' => 'append',
    'settings.determineRouteBeforeAppMiddleware' => false,
    'settings.displayErrorDetails' => true,
    'settings.addContentLengthHeader' => true,
    'settings.routerCacheFile' => false,
	
    'settings' => [
			'httpVersion' => get('settings.httpVersion'),
			'responseChunkSize' => get('settings.responseChunkSize'),
			'outputBuffering' => get('settings.outputBuffering'),
			'determineRouteBeforeAppMiddleware' => get('settings.determineRouteBeforeAppMiddleware'),
			'displayErrorDetails' => get('settings.displayErrorDetails'),
			'addContentLengthHeader' => get('settings.addContentLengthHeader'),
			'routerCacheFile' => get('settings.routerCacheFile')
	],
];