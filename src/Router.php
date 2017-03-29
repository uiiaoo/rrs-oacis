<?php

namespace adf;

use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use Phroute\Phroute\Exception\HttpMethodNotAllowedException;
use adf\Config;

class Router {
	function routing() {
		// ルーティング用ライブラリの読み込み
		$router = new RouteCollector ();
		
		$router->any ( '/example', function () {
			return 'This route responds to any method (POST, GET, DELETE etc...) at the URI /example';
		} );
		
		$router->any ( '/', function () {
			// トップページ
			include (Config::SRC_REAL_URL . 'controller/Home.php');
			return;
		} );
		
		$router->any ( '/agent/upload', function () {
			// zipを受け取る
			include (Config::SRC_REAL_URL . 'controller/FileUpload.php');
			return;
		} );
		
		// Print out the value returned from the dispatched function
		try {
			echo '  bb  :: ';
			$dispatcher = new Dispatcher ( $router->getData () );
			$response = $dispatcher->dispatch ( $_SERVER ['REQUEST_METHOD'], $_SERVER ['REQUEST_URI'] );
			echo $response;
			exit ();
		} catch ( HttpRouteNotFoundException $e ) {
			print '<pre>';
			print_r ( $e );
			print '</pre>';
			exit ();
		} catch ( HttpMethodNotAllowedException $e ) {
			print '<pre>';
			print_r ( $e );
			print '</pre>';
			exit ();
		}
	}
}

?>
