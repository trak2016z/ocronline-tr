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
        $user = new \OCROnline\Entity\User();

        $form = $app['form.factory']->createBuilder(UserType::class, $user)->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $encoder = $app['security.encoder_factory']->getEncoder($user);
            $password = $encoder->encodePassword($user->getPlainPassword(), $user->getSalt());
            $user->setPassword($password);

            $em = $app['orm.em'];

            $role_user = $em->getRepository('OCROnline\Entity\Role')->findOneBy(array('type' => 'ROLE_USER'));
            $user->getRolesORM()->add($role_user);

            $em->persist($user);
            $em->flush();
            return $app->redirect('/');            
        }
        

        return $app['twig']->render('register/index.html.twig', array('form' => $form->createView()));
    }
}