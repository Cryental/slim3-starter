<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function Index($request, $response)
    {
        return $this->c->view->render($response, 'home.twig');
    }
}
