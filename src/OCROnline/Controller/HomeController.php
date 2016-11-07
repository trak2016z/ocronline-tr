<?php

namespace OCROnline\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class HomeController
{
    public function indexAction(Request $request, Application $app)
    {
        return $app['twig']->render('home/index.html.twig');
    }
}