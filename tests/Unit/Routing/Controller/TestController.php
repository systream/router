<?php

namespace Tests\Systream\Unit\Routing\Controller;


use Systream\Controller\ControllerAbstract;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;

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
	 * @param Response $response
	 * @param ServerRequest $request
	 * @return Response
	 */
	public function get(Response $response, ServerRequest $request)
	{
		if ($request->getAttribute('id')) {
			$response->getBody()->write('param: ' . $request->getAttribute('id') . ' ');
		}
		return $this->sendResponse(__METHOD__, $response);
	}

	/**
	 * @param Response $response
	 * @param ServerRequest $request
	 * @return Response
	 */
	public function options(Response $response, ServerRequest $request)
	{
		if ($request->getAttribute('id') && $request->getAttribute('id2')) {
			$response->getBody()->write('param: ' . $request->getAttribute('id') . ',' . $request->getAttribute('id2') . ' ');
		}
		return $this->sendResponse(__METHOD__, $response);
	}

	/**
	 * @param Response $response
	 * @param ServerRequest $request
	 * @return Response
	 */
	public function post(Response $response, ServerRequest $request)
	{
		return $this->sendResponse(__METHOD__, $response);
	}

	/**
	 * @param Response $response
	 * @param ServerRequest $request
	 * @return Response
	 */
	public function put(Response $response, ServerRequest $request)
	{
		return $this->sendResponse(__METHOD__, $response);
	}

	/**
	 * @param Response $response
	 * @param ServerRequest $request
	 * @return Response
	 */
	public function delete(Response $response, ServerRequest $request)
	{
		return $this->sendResponse(__METHOD__, $response);
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