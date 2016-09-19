<?php


namespace Tests\Systream\Unit;


use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\EmitterInterface;

abstract class TestAbstract extends \PHPUnit_Framework_TestCase implements EmitterInterface
{
	/**
	 * @var ResponseInterface
	 */
	protected $response;

	/**
	 * @param ResponseInterface $response
	 */
	public function emit(ResponseInterface $response)
	{
		$this->response = $response;
	}
}