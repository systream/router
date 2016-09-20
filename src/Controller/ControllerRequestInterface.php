<?php

namespace Systream\Controller;



use Psr\Http\Message\ServerRequestInterface;

interface ControllerRequestInterface
{
	/**
	 * @param ServerRequestInterface $request
	 * @param array $params
	 * @return static|ControllerRequestInterface
	 */
	public static function create(ServerRequestInterface $request, array $params = array());

	/**
	 * @return ServerRequestInterface
	 */
	public function getServerRequest();

	/**
	 * @return array
	 */
	public function getParams();

	/**
	 * @param string $paramName
	 * @return string
	 */
	public function getParam($paramName);

}