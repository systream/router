<?php

namespace Tests\Systream\Unit\Routing;


use Systream\Routing\PathBasedRouting;
use Tests\Systream\Unit\Routing\Controller\IndexController;
use Tests\Systream\Unit\Routing\Controller\Sub\MainController;
use Tests\Systream\Unit\Routing\Controller\TestController;
use Tests\Systream\Unit\TestAbstract;

class PathBasedRoutingTest extends TestAbstract
{

	/**
	 * @var string
	 */
	protected $baseNameSpace = 'Tests\Systream\Unit\Routing\Controller';

	/**
	 * @test
	 */
	public function findByFile()
	{
		$route = new PathBasedRouting($this->getControllerPath(), $this->baseNameSpace);
		$this->assertEquals(new TestController(), $route->getController('/test'));
	}

	/**
	 * @test
	 */
	public function findByFile_endingSlash()
	{
		$route = new PathBasedRouting($this->getControllerPath(), $this->baseNameSpace);
		$this->assertEquals(new TestController(), $route->getController('/test/'));
	}

	/**
	 * @test
	 */
	public function findByFile_UpperFistLetter()
	{
		$route = new PathBasedRouting($this->getControllerPath(), $this->baseNameSpace);
		$this->assertEquals(new TestController(), $route->getController('/Test'));
	}

	/**
	 * @test
	 */
	public function findByFile_SubDir()
	{
		$route = new PathBasedRouting($this->getControllerPath(), $this->baseNameSpace);
		$this->assertEquals(new MainController(), $route->getController('/sub/main'));
	}

	/**
	 * @test
	 */
	public function findByFile_SubDir_SecondPathFirstLetterUpperCase()
	{
		$route = new PathBasedRouting($this->getControllerPath(), $this->baseNameSpace);
		$this->assertEquals(new MainController(), $route->getController('/sub/Main'));
	}

	/**
	 * @test
	 */
	public function cantStepUpDir()
	{
		$route = new PathBasedRouting($this->getControllerPath() . DIRECTORY_SEPARATOR . 'Sub', $this->baseNameSpace . '\\Sub');
		$this->assertFalse($route->getController('/../test'));
	}

	/**
	 * @test
	 */
	public function notFound()
	{
		$route = new PathBasedRouting($this->getControllerPath() . DIRECTORY_SEPARATOR, $this->baseNameSpace);
		$this->assertFalse($route->getController('/foo'));
	}

	/**
	 * @test
	 * @expectedException \Systream\Routing\Exception\ControllerNotFoundException
	 */
	public function pathNotExists()
	{
		new PathBasedRouting(
			__DIR__ . DIRECTORY_SEPARATOR . 'Controllers2',
			'Tests\UnitTests\Core\Routing\Controllers'
		);
	}

	/**
	 * @test
	 */
	public function indexMatch()
	{
		$route = new PathBasedRouting($this->getControllerPath(), $this->baseNameSpace);
		$this->assertEquals(new IndexController(), $route->getController('/'));
	}

	/**
	 * @test
	 */
	public function indexMatch_withNull()
	{
		$route = new PathBasedRouting($this->getControllerPath(), $this->baseNameSpace);
		$this->assertEquals(new IndexController(), $route->getController(null));
	}

	/**
	 * @test
	 */
	public function findWithGetParams()
	{
		$route = new PathBasedRouting($this->getControllerPath(), $this->baseNameSpace);
		$this->assertEquals(new IndexController(), $route->getController('/?test=1'));
	}

	/**
	 * @test
	 */
	public function checkGetParamsReturnArray()
	{
		$route = new PathBasedRouting($this->getControllerPath(), $this->baseNameSpace);
		$route->getController('/test');
		$this->assertInternalType('array', $route->getParams());
		$this->assertEmpty($route->getParams());
	}

	/**
	 * @return string
	 */
	protected function getControllerPath()
	{
		return __DIR__ . DIRECTORY_SEPARATOR . 'Controller';
	}
}
