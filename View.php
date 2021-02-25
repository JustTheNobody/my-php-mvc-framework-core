<?php

/**
 *  Class View
 *
 * @author Martin Maly
 * @package app\core
 */

namespace app\core;

class View
{
    public string $title = '';

    public function renderView($view, $params = [])
    {
        $viewContent = $this->renderOnlyView($view, $params);
        //$layoutContent -> render layout (does everything exist when the layout is rendered? (title, etc ))
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    protected function layoutContent()
    {
        //default layout
        $layout = Application::$app->layout;
        //if the layout exist => controller layout will overide the application layout
        if (Application::$app->controller) {
            $layout = Application::$app->controller->layout;
        }
        //cesh the buffer, nothing it output in browser
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/$layout.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view, $params)
    {
        foreach ($params as $key => $value) {
            //$$declare the key as name var
            $$key = $value;
        }

        //cesh the buffer, nothing it output in browser
        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }
}
