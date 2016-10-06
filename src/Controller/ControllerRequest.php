<?php

namespace Systream\Controller;


use Psr\Http\Message\ServerRequestInterface;

class ControllerRequest implements ControllerRequestInterface
{
	/**
	 * @var ServerRequestInterface
	 */
	private $request;

	/**
	 * @var array
	 */
	private $params;

	/**
	 * ControllerRequest constructor.
	 * @param ServerRequestInterface $request
	 * @param array $params
	 */
	public function __construct(ServerRequestInterface $request, array $params = array())
	{
		$this->request = $request;
		$this->params = $params;
	}


	/**
	 * @param ServerRequestInterface $request
	 * @param array $params
	 * @return static|ControllerRequestInterface
	 */
	public static function create(ServerRequestInterface $request, array $params = array())
	{
		return new static($request, $params);
	}

	/**
	 * @return ServerRequestInterface
	 */
	public function getServerRequest()
	{
		return $this->request;
	}

	/**
	 * @return array
	 */
	public function getUrlParams()
	{
		return $this->params;
	}

	/**
	 * @param string $paramName
	 * @return string
	 */
	public function getUrlParam($paramName)
	{
		return isset($this->params[$paramName]) ? $this->params[$paramName] : null;
	}

	/**
	 * Return with post parameters
	 *
	 * @return mixed
	 */
	public function getQueryParams()
	{
		return $this->request->getQueryParams();
	}
}