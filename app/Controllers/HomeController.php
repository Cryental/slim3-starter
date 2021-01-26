<?php

namespace App\Controllers;

use App\Models\AnimeEntities;
use App\Models\AnimeMetadata;

class HomeController extends BaseController
{
    public function Index($request, $response)
    {
        return $this->c->view->render($response, 'home.twig');
    }
}