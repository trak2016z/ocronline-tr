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
        $em = $app['orm.em'];
        $token = $app['security.token_storage']->getToken();
        $user = $token->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $document->setUser($user);
            $document->readFileContents();
            $em->persist($document);
            $em->flush();
        }

        $documents = $user->getDocuments();
        return $app['twig']->render('user/index.html.twig',
            array(
                'form' => $form->createView(),
                'documents' => $documents,
            )
        );
    }
}