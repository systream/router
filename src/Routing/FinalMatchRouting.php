<?php
namespace Systream\Routing;


use Systream\Controller\ControllerInterface;

class FinalMatchRouting extends RoutingAbstract implements RouteInterface
{
	/**
	 * @var ControllerInterface
	 */
	protected $controller;

	/**
	 * @param $controller
	 */
	public function __construct(ControllerInterface $controller)
	{
		$this->controller = $controller;
	}

	/**
	 * @param $uri
	 * @return string
	 */
	public function getController($uri)
	{
		return $this->controller;
	}

	/**
	 * @return array
	 */
	public function getParams()
	{
		return array();
	}
}