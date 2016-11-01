<?php
namespace Systream\Routing;


use Systream\Controller\ControllerInterface;

interface RouteInterface {

	/**
	 * @param string $uri
	 * @return ControllerInterface|bool
	 */
	public function getController($uri);

	/**
	 * @return array
	 */
	public function getParams();
}