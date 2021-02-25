<?php

/**
 *  Class Router
 *
 * @author Martin Maly
 * @package app\core
 */

namespace app\core;

use app\core\exception\NotFoundException;

class Router
{

    public Request $request;
    public Response $response;
    protected array $routes = [];

    /**
     * Router constractor
     *
     * @param \app\core\Request $request
     * @param \app\core\Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        // get/post
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            throw new NotFoundException();
        }

        if (is_string($callback)) {
            //assume its the view name
            return Application::$app->view->renderView($callback);
        }

        //change the array [0] to object
        if (is_array($callback)) {
            /** @var \app\core\Controller $controller */
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;

            foreach ($controller->getMiddlewares() as $middleware) {
                $middleware->execute();
            }
        }
        //return string
        return call_user_func($callback, $this->request, $this->response);
    }
}
