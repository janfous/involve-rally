<?php

declare(strict_types=1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList;
		$router->addRoute('<presenter>/<action>[/<id>]', 'Homepage:default');

        //member routers
		$router->addRoute('member/form', 'Member:form');
		$router->addRoute('member/grid', 'Member:grid');
		
		//team routers
		$router->addRoute('team/form', 'Team:form');
		$router->addRoute('team/grid', 'Team:grid');
		return $router;
	}
}
