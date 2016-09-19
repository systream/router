<?php

namespace Tests\Systream\Unit\Routing;


use Systream\Routing\SimpleRouting;
use Tests\Systream\Unit\Routing\Controller\TestController;
use Tests\Systream\Unit\TestAbstract;

class SimpleRoutingTest extends TestAbstract
{

	/**
	 * @test
	 */
	public function findMatch()
	{
		$controller = new TestController();
		$simpleRouting = new SimpleRouting('/test', $controller);
		$this->assertEquals(
			$controller,
			$simpleRouting->getController('/test')
		);
	}

	/**
	 * @test
	 */
	public function notFindMatch()
	{
		$simpleRouting = new SimpleRouting('/test', new TestController());
		$this->assertFalse(
			$simpleRouting->getController('/test2')
		);
	}

	/**
	 * @test
	 */
	public function findWithVariable()
	{
		$controller = new TestController();
		$simpleRouting = new SimpleRouting('/test/{id}', $controller);
		$this->assertEquals(
			$controller,
			$simpleRouting->getController('/test/10')
		);
	}

	/**
	 * @test
	 */
	public function notFindMatchWithVariable()
	{
		$simpleRouting = new SimpleRouting('/test/{id}/{anotherID}/', new TestController());
		$this->assertFalse(
			$simpleRouting->getController('/test/q23/12/asd')
		);
	}

	/**
	 * @test with get parameters
	 */
	public function findWithGetParameters()
	{
		$controller = new TestController();
		$simpleRouting = new SimpleRouting('/test/{id}', $controller);
		$this->assertEquals(
			$controller,
			$simpleRouting->getController('/test/2?id=01')
		);
	}

	/**
	 * @test with ending slash
	 */
	public function findWithEndingSlash()
	{
		$controller = new TestController();
		$simpleRouting = new SimpleRouting('/test', $controller);
		$this->assertEquals(
			$controller,
			$simpleRouting->getController('/test/')
		);
	}

	/**
	 * @test
	 */
	public function getParams()
	{
		$simpleRouting = new SimpleRouting('/test/{id}/{magic}', new TestController());

		$simpleRouting->getController('/test/10/something');
		$this->assertEquals(
			array(
				'id' => '10',
				'magic' => 'something'
			),
			$simpleRouting->getParams()
		);
	}

}
