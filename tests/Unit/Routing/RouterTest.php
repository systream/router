<?php

namespace Tests\Systream\Unit\Routing;

use Systream\Router;
use Systream\Routing\FinalMatchRouting;
use Systream\Routing\SimpleRouting;
use Tests\Systream\Unit\Routing\Controller\TestController;
use Tests\Systream\Unit\TestAbstract;
use Zend\Diactoros\ServerRequestFactory;

class RouterTest extends TestAbstract
{
	/**
	 * @test
	 * @expectedException \Systream\Router\Exception\RouteNotFoundException
	 */
	public function emptyRouting()
	{
		$serverRequest = ServerRequestFactory::fromGlobals([
			'REQUEST_URI' => '/foo'
		]);

		$route = new Router();
		$route->dispatch($serverRequest, $this);
	}

	/**
	 * @test
	 * @expectedException \Systream\Router\Exception\RouteNotFoundException
	 */
	public function noRoutingFound()
	{
		$serverRequest = ServerRequestFactory::fromGlobals([
			'REQUEST_URI' => '/foo'
		]);

		$route = new Router();
		$route->addRoute(new SimpleRouting('/abcde', new TestController()));
		$route->dispatch($serverRequest, $this);
	}

	/**
	 * @test
	 * @dataProvider methodDataProvider
	 * @param string $method
	 */
	public function routeFoundWithSimpleRoute($method)
	{
		$serverRequest = ServerRequestFactory::fromGlobals([
			'REQUEST_URI' => '/foo',
			'REQUEST_METHOD' => $method
		]);

		$route = new Router();
		$controller = new TestController();
		$route->addRoute(new SimpleRouting('/foo', $controller));
		$route->dispatch($serverRequest, $this);
	}

	/**
	 * @test
	 */
	public function routeFoundMethodNotAllowed()
	{
		$serverRequest = ServerRequestFactory::fromGlobals([
			'REQUEST_URI' => '/foo',
			'REQUEST_METHOD' => 'PATCH'
		]);

		$route = new Router();
		$controller = new TestController();
		$route->addRoute(new SimpleRouting('/foo', $controller));
		$route->dispatch($serverRequest, $this);
		$this->assertEquals(405, $this->response->getStatusCode());
	}

	/**
	 * @test
	 * @dataProvider methodDataProvider
	 * @param $method
	 */
	public function routeOrderTest_firstCatch($method)
	{
		$serverRequest = ServerRequestFactory::fromGlobals([
			'REQUEST_URI' => '/foo',
			'REQUEST_METHOD' => $method
		]);

		$route = new Router();
		$route->addRoute(new SimpleRouting('/foo', new TestController('simple')));
		$route->addRoute(new FinalMatchRouting(new TestController('final')));
		$route->dispatch($serverRequest, $this);
		$this->assertEquals(strtolower($method) . ' simple', $this->response->getBody());
	}

	/**
	 * @test
	 * @dataProvider methodDataProvider
	 * @param $method
	 */
	public function routeOrderTest_lastCatch($method)
	{
		$serverRequest = ServerRequestFactory::fromGlobals([
			'REQUEST_URI' => '/foo2',
			'REQUEST_METHOD' => $method
		]);

		$route = new Router();
		$route->addRoute(new SimpleRouting('/foo', new TestController('simple')));
		$route->addRoute(new FinalMatchRouting(new TestController('final')));
		$route->dispatch($serverRequest, $this);
		$this->assertEquals(strtolower($method) . ' final', $this->response->getBody());
	}

	/**
	 * @test
	 * @dataProvider paramsDataProvider
	 * @param $data
	 */
	public function passVariables($data)
	{
		$serverRequest = ServerRequestFactory::fromGlobals([
			'REQUEST_URI' => '/foo/' . $data,
			'REQUEST_METHOD' => 'GET'
		]);

		$route = new Router();
		$route->addRoute(new SimpleRouting('/foo/{id}', new TestController()));
		$route->dispatch($serverRequest, $this);
		$this->assertEquals('param: ' . $data . ' get', (string)$this->response->getBody());
	}


	/**
	 * @test
	 * @dataProvider paramsDataProvider
	 * @param $data1
	 * @param $data2
	 */
	public function pass2Variables($data1, $data2)
	{
		$serverRequest = ServerRequestFactory::fromGlobals([
			'REQUEST_URI' => '/foo/' . $data1 . '/' . $data2 ,
			'REQUEST_METHOD' => 'OPTIONS'
		]);

		$route = new Router();
		$route->addRoute(new SimpleRouting('/foo/{id}/{id2}', new TestController()));
		$route->dispatch($serverRequest, $this);
		$this->assertEquals('param: ' . $data1 . ',' . $data2 . ' options', (string)$this->response->getBody());
	}
	/**
	 * @return array
	 */
	public function paramsDataProvider()
	{
		return array(
			array('foo', 'bar'),
			array('foo2', 'asdas asd '),
			array('-', '*%'),
			array('*', 'űáőúl'),
			array('áűúőé', 'bar'),
			array('dd bb', 'bar'),
			array('--', 'asd-őapsd'),
			array('   |ˆa', '   |ˆa'),
			array('12345', '12345')
		);
	}

	/**
	 * @return array
	 */
	public function methodDataProvider()
	{
		return array(
			array('GET'),
			array('POST'),
			array('PUT'),
			array('DELETE'),
			array('OPTIONS'),
		);
	}

}
