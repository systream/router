<?php
namespace Systream\Routing;

use Systream\Controller\ControllerInterface;

class SimpleRouting extends RoutingAbstract implements RouteInterface
{
	/**
	 * Variable delimiter
	 */
	const VARIABLE_DELIMITER = '§';

	/**
	 * @var string
	 */
	protected $testUri;

	/**
	 * @var ControllerInterface
	 */
	protected $controller;

	/**
	 * @var array
	 */
	protected $params = array();

	/**
	 * @param string $testUri
	 * @param ControllerInterface $controllerName
	 */
	public function __construct($testUri, ControllerInterface $controllerName)
	{
		$this->testUri = $testUri;
		$this->controller = $controllerName;
	}

	/**
	 * @param $uri
	 * @return string
	 */
	public function getController($uri)
	{
		$this->removeGetParamsFormUri($uri);

		preg_match_all("|{(.*)}+|U", $this->testUri, $params, PREG_PATTERN_ORDER);

		$escapedPath = preg_quote($this->testUri, '/');
		if (!empty($params)) {
			foreach ($params[0] as $param) {
				$escapedPath = str_replace(
					'\\' . str_replace('}', '\\}', $param),
					'(.+)',
					$escapedPath
				);
			}
		}

		preg_match('/^' . $escapedPath . '\/?$/i', $uri, $found);
		if (!empty($found)) {

			if (!empty($params)) {
				$index = 1;
				foreach ($params[1] as $param) {
					$this->params[$param] = rawurldecode($found[$index++]);
				}
			}
			return $this->controller;
		}
		return false;
	}

	/**
	 * @return array
	 */
	public function getParams()
	{
		return $this->params;
	}
}