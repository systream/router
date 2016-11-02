<?php

namespace Systream\Controller;


use Psr\Http\Message\ResponseInterface;
use Systream\DependencyInjectionContainer\DependencyInjectionContainerInterface;

interface ControllerInterface
{
	/**
	 * @param string $methodType
	 * @param ResponseInterface $response
	 * @param ControllerRequestInterface $controllerRequest
	 * @return ResponseInterface
	 */
	public function callMethod(
		$methodType,
		ResponseInterface $response,
		ControllerRequestInterface $controllerRequest
	);
}