<?php
namespace Systream\Router;


use Psr\Http\Message\ServerRequestInterface;
use Systream\Routing\RouteInterface;
use Zend\Diactoros\Response\EmitterInterface;

interface RouterInterface
{
	/**
	 * @param RouteInterface $routeInterface
	 * @return void
	 */
	public function addRoute(RouteInterface $routeInterface);

	/**
	 * @param ServerRequestInterface $serverRequest
	 * @param EmitterInterface $emitter
	 */
	public function dispatch(ServerRequestInterface $serverRequest, EmitterInterface $emitter);
}