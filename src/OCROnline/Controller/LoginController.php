<?php

namespace OCROnline\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class LoginController
{
    public function indexAction(Request $request, Application $app)
    {
        return $app['twig']->render('login/index.html.twig',
            array(
                'error'         => $app['security.last_error']($request),
                'last_username' => $app['session']->get('_security.last_username'),
            )
        );
    }
}