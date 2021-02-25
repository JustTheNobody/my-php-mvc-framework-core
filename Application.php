<?php

/**
 *  Class Application
 *
 * @author Martin Maly
 * @package app\core
 */

namespace app\core;

use app\core\db\Database;

class Application
{
    public static string $ROOT_DIR;

    public string $layout = 'main';
    public string $userClass;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public Database $db;

    public static Application $app;
    public Controller $controller;
    public ?UserModel $user;  // ? -> may be NULL
    public View $view;

    public function __construct($rootPath, array $config)
    {
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        self::$app->user = null;  // i did add
        $this->controller = new Controller();
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->view = new View();

        $this->db = new Database($config['db']);

        $primaryValue = $this->session->get('user');
        if ($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        }
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            $this->response->setStatusCode($e->getCode());
            //display exeption message
            echo $this->view->renderView('_error', [
                'exception' => $e
            ]);
        }
    }

    public static function isGuest()
    {
        return !self::$app->user;
    }

    /**
     * @return \app\core\Controller
     */
    public function getController(): \app\core\Controller
    {
        return $this->controller;
    }

     /**
     * @return \app\core\Controller $controller
     */
    public function setController(\app\core\Controller $controller): void
    {
        
        $this->controller = $controller;
    }

    public function login(UserModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey}; //accessing $primaryKey property
        $this->session->set('user', $primaryValue);
        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }
}
