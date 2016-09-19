<?php
namespace Systream\Routing;
use Systream\Routing\Exception\ControllerNotFoundException;

class PathBasedRouting extends RoutingAbstract implements RouteInterface
{
	/**
	 * @var string
	 */
	protected $path;
	/**
	 * @var string
	 */
	protected $baseNameSpace;


	/**
	 * @param string $path
	 * @param string $baseNameSpace
	 * @throws ControllerNotFoundException
	 */
	public function __construct($path, $baseNameSpace)
	{
		if (!file_exists($path)) {
			throw new ControllerNotFoundException(sprintf('%s routing file path not exits', $path));
		}
		$this->path = $path;
		$this->baseNameSpace = $baseNameSpace;
	}

	/**
	 * @param $uri
	 * @return string
	 */
	public function getController($uri)
	{
		if (strpos($uri, '..')) {
			return false;
		}

		$this->removeGetParamsFormUri($uri);


		if ($uri === '/' || $uri === null) {
			$controllerPath = 'IndexController';
		} else {
			$uri = rtrim($uri, '/');
			$uriTags = explode('/', $uri);
			foreach ($uriTags as &$uriTag) {
				$uriTag = ucfirst($uriTag);
			}
			$uri = implode('/', $uriTags);
			$controllerPath = ucfirst(ltrim($uri, '/')) . 'Controller';
		}

		$fullFileName = $this->path . DIRECTORY_SEPARATOR . $controllerPath . '.php';
		if (file_exists($fullFileName)) {
			$className = str_replace('/', '\\', $this->baseNameSpace . '\\' . $controllerPath);
			return new $className();
		}
		return false;
	}

	/**
	 * @return array
	 */
	public function getParams()
	{
		return array();
	}
}