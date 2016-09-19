<?php

namespace Tests\Systream\Unit\Routing\Controller;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Systream\Controller\ControllerAbstract;
use Zend\Diactoros\Response;

class TestController extends ControllerAbstract
{
	/**
	 * @var
	 */
	private $context = '';

	/**
	 * @var array
	 */
	public $calledMethods = array();

	/**
	 * TestController constructor.
	 * @param string $context
	 */
	public function __construct($context = '')
	{
		$this->context = $context;
	}

	/**
	 * @param ServerRequestInterface $serverRequest
	 * @param Response $response
	 * @param null $param1
	 * @return Response
	 */
	public function get(ServerRequestInterface $serverRequest, Response $response, $param1 = null)
	{
		if ($param1) {
			$response->getBody()->write('param: ' . $param1 . ' ');
		}
		return $this->sendResponse(__METHOD__, $response);
	}

	/**
	 * @param ServerRequestInterface $serverRequest
	 * @param Response $response
	 * @return Response
	 */
	public function options(ServerRequestInterface $serverRequest, Response $response, $param1 = null, $param2 = null)
	{
		if ($param1 && $param2) {
			$response->getBody()->write('param: ' . $param1 . ',' . $param2 . ' ');
		}
		return $this->sendResponse(__METHOD__, $response);
	}

	/**
	 * @param ServerRequestInterface $serverRequest
	 * @param Response $response
	 * @return Response
	 */
	public function post(ServerRequestInterface $serverRequest, Response $response)
	{
		return $this->sendResponse(__METHOD__, $response);
	}

	/**
	 * @param ServerRequestInterface $serverRequest
	 * @param Response $response
	 * @return Response
	 */
	public function put(ServerRequestInterface $serverRequest, Response $response)
	{
		return $this->sendResponse(__METHOD__, $response);
	}

	/**
	 * @param ServerRequestInterface $serverRequest
	 * @param Response $response
	 * @return Response
	 */
	public function delete(ServerRequestInterface $serverRequest, Response $response)
	{
		return $this->sendResponse(__METHOD__, $response);
	}

	/**
	 * @param string $methodType
	 * @param ServerRequestInterface $serverRequest
	 * @param ResponseInterface $response
	 * @param array $params
	 * @return ResponseInterface|void
	 */
	public function callMethod(
		$methodType,
		ServerRequestInterface $serverRequest,
		ResponseInterface $response,
		array $params
	) {
		$this->calledMethods[] = array(
			'methodType' => $methodType,
			'serverRequest' => $serverRequest,
			'params' => $params
		);

		return parent::callMethod($methodType, $serverRequest, $response, $params);
	}

	/**
	 * @param string $method
	 * @param Response $response
	 * @return Response
	 */
	private function sendResponse($method, Response $response)
	{
		$method = explode('::', $method);
		$methodName = $method[1];

		if ($this->context) {
			$methodName .= ' ' . $this->context;
		}
		$response->getBody()->write($methodName);
		return $response;
	}
}