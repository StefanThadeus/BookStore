<?php

namespace BookStore\Application;

// Router class which chooses the correct controller and method from the URL
class Router
{
    // default controller is AuthorController and default method is authorList
    protected $currentController = 'BookStore\Application\Presentation\MultiPage\Controllers\AuthorController';
    protected $currentMethod = 'defaultPage';
    protected array $params = [];

    public function __construct()
    {
        // load list of all controllers and their methods that may be referred to via URL
        $routes = require $_SERVER['DOCUMENT_ROOT'] . '/../config/Routes.php';

        // remove base URL
        $url = substr($_GET['url'], strpos($_GET['url'], Router::getBaseURL()));

        foreach ($routes as $route)
        {
            foreach ($route as $nestedRoute){
                if ($nestedRoute['path'] === $url) {
                    $this->currentController = $nestedRoute['controller'];
                    $this->currentMethod = $nestedRoute['method'];
                    call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
                    return;
                }
            }
        }
    }

    // returns the base website URL to method caller
    public static function getBaseURL(): string
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domainName = $_SERVER['HTTP_HOST'] . '/';

        return $protocol . $domainName;
    }
}
