<?php

/**
 *  Class Controller
 *
 * @author Martin Maly
 * @package app\core
 *
 */

namespace app\core;

use app\core\Middlewares\BaseMiddleware;

class Controller
{

    public string $layout = 'main';
    public string $actions = '';

    /**
     * @var \app\core\middlewares\BaseMiddleware[]
     */
    protected array $middlewares = [];

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function render($view, $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * @return \app\core\middleware\BaseMiddleware[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}
