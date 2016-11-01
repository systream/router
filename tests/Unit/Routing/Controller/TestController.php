<?php

namespace Tests\Systream\Unit\Routing\Controller;


use Systream\Controller\ControllerAbstract;
use Systream\Controller\ControllerRequest;
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
	 * @param Response $response
	 * @param ControllerRequest $request
	 * @return Response
	 */
	public function get(Response $response, ControllerRequest $request)
	{
		if ($request->getUrlParam('id')) {
			$response->getBody()->write('param: ' . $request->getUrlParam('id') . ' ');
		}
		return $this->sendResponse(__METHOD__, $response);
	}

	/**
	 * @param Response $response
	 * @param ControllerRequest $request
	 * @return Response
	 */
	public function options(Response $response, ControllerRequest $request)
	{
		if ($request->getUrlParam('id') && $request->getUrlParam('id2')) {
			$response->getBody()->write('param: ' . $request->getUrlParam('id') . ',' . $request->getUrlParam('id2') . ' ');
		}
		return $this->sendResponse(__METHOD__, $response);
	}

	/**
	 * @param Response $response
	 * @param ControllerRequest $request
	 * @return Response
	 */
	public function post(Response $response, ControllerRequest $request)
	{
		return $this->sendResponse(__METHOD__, $response);
	}

	/**
	 * @param Response $response
	 * @param ControllerRequest $request
	 * @return Response
	 */
	public function put(Response $response, ControllerRequest $request)
	{
		return $this->sendResponse(__METHOD__, $response);
	}

	/**
	 * @param Response $response
	 * @param ControllerRequest $request
	 * @return Response
	 */
	public function delete(Response $response, ControllerRequest $request)
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

	public function getDI()
	{
		return $this->getDependencyInjectionContainer();
	}
}