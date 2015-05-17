<?php

namespace App;

use Nette,
	Nette\Application\Routers\RouteList,
	Nette\Application\Routers\Route,
	Nette\Application\Routers\SimpleRouter;


/**
 * Router factory.
 */
class RouterFactory
{

	/**
	 * @return \Nette\Application\IRouter
	 */
	public function createRouter()
	{
		$router = new RouteList();
		$router[] = new Route('search', 'Homepage:search');
		$router[] = new Route('license', 'Homepage:license');
		$router[] = new Route('demo/<action>/<file>', 'Demo:default');
		$router[] = $this->getDefaultRoute();
		return $router;
	}

	private function getDefaultRoute()
	{
		return new Route('<presenter>/<action>[/<id>]', 'Homepage:default');
	}
}
