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
	 * Return with post parameters
	 *
	 * @param static $parameterName
	 * @return mixed
	 */
	public function getAttribute($parameterName);

	/**
	 * @return array
	 */
	public function getUrlParams();

	/**
	 * @param string $paramName
	 * @return string
	 */
	public function getUrlParam($paramName);

}