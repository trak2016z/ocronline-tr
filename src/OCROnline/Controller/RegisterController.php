<?php

namespace OCROnline\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use OCROnline\Form\UserType;

class RegisterController
{
    public function indexAction(Request $request, Application $app)
    {
        /*$data = array(
            'name' => 'Your name',
            'email' => 'Your email',
        );*/

        $form = $app['form.factory']->createBuilder('OCROnline\\Form\\UserType', null)->getForm();

        return $app['twig']->render('register/index.html.twig', array('form' => $form->createView()));
    }
}