<?php

namespace OCROnline\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use OCROnline\Form\DocumentType;

class UserController
{
    public function indexAction(Request $request, Application $app)
    {
        $document = new \OCROnline\Entity\Document();
        $form = $app['form.factory']->createBuilder(DocumentType::class, $document)->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $app['orm.em'];
            $token = $app['security.token_storage']->getToken();
            $user = $token->getUser();
            $document->setUser($user);
            $em->persist($document);
            $em->flush();
        }
        return $app['twig']->render('user/index.html.twig', array('form' => $form->createView()));
    }
}