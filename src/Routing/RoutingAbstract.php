<?php
namespace Systream\Routing;


abstract class RoutingAbstract implements RouteInterface
{
	/**
	 * @param $uri
	 */
	protected function removeGetParamsFormUri(&$uri)
	{
		if ($uri !== null) {
			$uri = strtok($uri, '?');
		}
	}
}