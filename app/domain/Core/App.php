<?php namespace Core;

use Core\Routing\Router;
use Exception;

class App
{
    public function run()
    {
        // imports stored configuration
        Config::importConfig();

        // turns on debugging
        $this->setDebug();

        // executes routes
        $router = new Router();
        $router->setBasePath(Config::get('app.basePath'));

        require_once Config::get('path') . '/app/routes.php';

        $route = $router->matchCurrentRequest();

        if ($route === false) {
            throw new Exception('Could not match request to any defined routes.');
        } else {
            $this->executeRoute($route->getTarget(), $route->getParameters());
        }
    }

    protected function setDebug($switch = true)
    {
        if (Config::get('app.debug') OR $switch) {
            error_reporting(E_ALL);
            ini_set("display_errors", 1);
        }

        if ($switch !== true) {
            error_reporting(0);
            ini_set("display_errors", 0);
        }
    }

    protected function isClosure($obj)
    {
        return is_object($obj) && ($obj instanceof Closure);
    }

    protected function executeRoute($target, array $parameters = array())
    {
        if ($this->isClosure($target)) {
            echo call_user_func_array($target, $parameters);
        } elseif (is_array($target)) {
            $controller = new $target['controller'];
            echo call_user_func_array(array($controller, $target['action']), $parameters);
        }
    }
}