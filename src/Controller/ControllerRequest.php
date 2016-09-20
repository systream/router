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
	public function getParams()
	{
		return $this->params;
	}

	/**
	 * @param string $paramName
	 * @return string
	 */
	public function getParam($paramName)
	{
		return isset($this->params[$paramName]) ? $this->params[$paramName] : null;
	}
}