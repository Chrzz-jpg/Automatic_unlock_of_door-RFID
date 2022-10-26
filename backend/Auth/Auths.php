<?php

namespace App\Auth;


use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Router;

class Auths
{
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Auth middleware invokable class
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
    **/
    public function __invoke(Request $request, Response $response, $next)
    {
        $loggedIn = $_SESSION['isLoggedIn'];
        if ($loggedIn != 'yes') {
            // If the user is not logged in, redirect them home
            return $response->withRedirect($this->router->pathFor('home'));
        }

        // The user must be logged in, so pass this request down the middleware chain
        $response = $next($request, $response);

        // And pass the request back up the middleware chain.
        return $response;
    }
}
