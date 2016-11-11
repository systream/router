<?php

namespace Systream\Controller;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class ControllerAbstract implements ControllerInterface
{
	/**
	 * @param string $methodType
	 * @param ResponseInterface $response
	 * @param ServerRequestInterface $request
	 * @return ResponseInterface
	 */
	public function callMethod(
		$methodType,
		ResponseInterface $response,
		ServerRequestInterface $request
	) {
		$method = strtolower($methodType);
		if (method_exists($this, $method)) {
			return $this->$method($response, $request);
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