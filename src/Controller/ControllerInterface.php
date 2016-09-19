<?php

namespace Systream\Controller;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface ControllerInterface
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
	);
}