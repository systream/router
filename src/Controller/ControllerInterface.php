<?php

namespace Systream\Controller;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface ControllerInterface
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
	);
}