<?php

namespace Tests\Systream\Unit\Routing;


use Systream\Routing\FinalMatchRouting;
use Tests\Systream\Unit\Routing\Controller\TestController;
use Tests\Systream\Unit\TestAbstract;

class FinalRoutingTest extends TestAbstract
{
	/**
	 * @test
	 */
	public function findMatch()
	{
		$controller = new TestController();
		$routing = new FinalMatchRouting($controller);
		$this->assertEquals(
			$controller,
			$routing->getController('/test')
		);
	}

	/**
	 * @test
	 */
	public function findMatch_withParams()
	{
		$controller = new TestController();
		$routing = new FinalMatchRouting($controller);
		$this->assertEquals(
			$controller,
			$routing->getController('/test/10')
		);
	}

	/**
	 * @test
	 */
	public function findMatch_withGetParams()
	{
		$controller = new TestController();
		$routing = new FinalMatchRouting($controller);
		$this->assertEquals(
			$controller,
			$routing->getController('/test/10?foo=bar')
		);
	}

	/**
	 * @test
	 */
	public function findMatch_withEndingSlash()
	{
		$controller = new TestController();
		$routing = new FinalMatchRouting($controller);
		$this->assertEquals(
			$controller,
			$routing->getController('/test/10/')
		);
	}

}
