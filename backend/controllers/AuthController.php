<?php

namespace App\Controllers;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;


class AuthController
{

    private $user;
    private $data;

 /**
   * Container Class
   * @var [object]
   */
  private $container;

  /**
   * Undocumented function
   * @param [object] $container
   */
  public function __construct($container)
  {
    $this->container = $container;
  }

  /* Deleta um Livro
   * @param [type] $request
   * @param [type] $response
   * @param [type] $args
   * @return Response
   */
    public function check($request, $response, $args)
    {
        $params = (object) $request->getParams();
        $nome = (string) $params->nome ;
        $pass = (string) $params->password ;
        $entityManager = $this->container->get('em');
        $view = $this->container->get('view');
        $usersRepo = $entityManager->getRepository('Entity\Users');
        $user = $usersRepo->findOneby(["nome"=>$nome]); 
       
        
        if ($user){
            $adminRepo = $entityManager->getRepository('Entity\Admin');
            $admin = $adminRepo->findOneby(["user"=>$user]); 
    
        }
        // if (!isset($user['password']) or !isset($this->data['password']))
        // return false;
        if ($admin) {
          
        if (password_verify($pass, $admin->getPassword()))
           {
            $_SESSION['isLoggedIn'] = 'yes';
            session_regenerate_id();
           
            // $return = $view->render($response, 'logs.html');
            return $response->withRedirect("/logs");
        
           }
        }
    
        // $return = $response->withJson(['nome' => $nome,"password"=>$pass], 200)
        // ->withHeader('Content-type', 'application/json')
        // ->withHeader("Access-Control-Allow-Origin", "*");
        // return $return;

        return $response->withRedirect("/");



        // function ($request, $response, $args) {
        //     // Check if the user's credentials are valid, then log them in however you keep track of users.
        //     // Obviously this method isn't secure, and is just used to illustrate the flow.
        //     if ($request->getParsedBodyParam('name') === 'user') {
        //         $_SESSION['isLoggedIn'] = 'yes';
        //         session_regenerate_id();
        //         // Login success, redirect to the dashboard.
        //         return $response->withRedirect($this->router->pathFor('dashboard'));
        //     }
        //     // Login failed, redirect home.
        //     return $response->withRedirect($this->router->pathFor('home'), 403);
        // }
  
    }

    public function access()
    {
        $_SESSION['user'] = $this->data;
    }

    public function validarUserbyName($name)
    {
        $entityManager = $this->container->get('em');
        $userRepo = $entityManager->getRepository('Entity\Users');
        $user = $userRepo->findOneBy([
            "nome" => $name,
            ]); 

        return $user ;
    }

}