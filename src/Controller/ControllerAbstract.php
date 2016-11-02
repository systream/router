<?php

namespace Systream\Controller;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Systream\DependencyInjectionContainer\DependencyInjectionContainerInterface;

abstract class ControllerAbstract implements ControllerInterface
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
	) {
		$method = strtolower($methodType);
		if (method_exists($this, $method)) {
			return $this->$method($response, $controllerRequest);
		}

		return $this->getMethodNotAllowedResponse($response);
	}

	/**
	 * @param ResponseInterface $response
	 * @return ResponseInterface
	 */
	protected function getMethodNotAllowedResponse(ResponseInterface $response)
	{
		return $response->withStatus(405, 'Method not allowed');
	}

}