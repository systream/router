<?php

namespace Systream\Controller;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class ControllerAbstract implements ControllerInterface
{

	/**
	 * @param string $methodType
	 * @param ServerRequestInterface $serverRequest
	 * @param ResponseInterface $response
	 * @param array $params
	 * @return ResponseInterface
	 */
	public function callMethod(
		$methodType,
		ServerRequestInterface $serverRequest,
		ResponseInterface $response,
		array $params
	) {

		$method = strtolower($methodType);
		if (method_exists($this, $method)) {

			$params = array_merge(
				array($serverRequest, $response),
				$params
			);

			return call_user_func_array(array($this, $method), $params);
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