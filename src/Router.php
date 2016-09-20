<?php
namespace Systream;

use Psr\Http\Message\ServerRequestInterface;
use Systream\Controller\ControllerRequest;
use Systream\Controller\ControllerRequestInterface;
use Systream\Router\Exception\RouteNotFoundException;
use Systream\Router\RouterInterface;
use Systream\Routing\RouteInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\EmitterInterface;

class Router implements RouterInterface
{
	/**
	 * @var RouteInterface[]
	 */
	protected $routes = array();

	/**
	 * @param RouteInterface $routeInterface
	 */
	public function addRoute(RouteInterface $routeInterface)
	{
		$this->routes[] = $routeInterface;
	}

	/**
	 * dispatch controller
	 * @param ServerRequestInterface $serverRequest
	 * @param EmitterInterface $emitter
	 */
	public function dispatch(ServerRequestInterface $serverRequest, EmitterInterface $emitter)
	{
		$emitter->emit($this->findController($serverRequest));
	}

	/**
	 * @param ServerRequestInterface $serverRequest
	 * @return \Psr\Http\Message\ResponseInterface
	 * @throws RouteNotFoundException
	 */
	private function findController(ServerRequestInterface $serverRequest)
	{
		foreach ($this->routes as $route) {
			if ($controller = $route->getController($serverRequest->getUri()->getPath())) {

				$controllerRequest = ControllerRequest::create($serverRequest, $route->getParams());
				$response = $controller->callMethod(
					$serverRequest->getMethod(),
					new Response(),
					$controllerRequest
				);
				return $response;
			}
		}

		throw new RouteNotFoundException(sprintf('No route found for %s', $serverRequest->getUri()->getPath()));
	}
}