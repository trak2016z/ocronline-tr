<?php

namespace OCROnline\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use OCROnline\Form\RecognizeType;

class DocumentController
{
    public function showAction(Request $request, Application $app, $id)
    {
        $em = $app['orm.em'];
        $document = $em->find("OCROnline\Entity\Document", $id);
        if (!$document) {
            $app->abort(404, 'Dokument nie istenieje.');
        }
        $token = $app['security.token_storage']->getToken();
        $user = $token->getUser();

        $auth_check = $app['security.authorization_checker'];

        $owned_by_user = $auth_check->isGranted('ROLE_USER')
                        && ( $auth_check->isGranted('ROLE_ADMIN')
                             || ($user->getId() == $document->getUser()->getId()) );
        
        $form = $app['form.factory']->createBuilder(RecognizeType::class, $document)->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $document->doRecognize();
            $em->persist($document);
            $em->flush();
        }

        return $app['twig']->render('document/show.html.twig',
                array(
                    'document' => $document,
                    'owned_by_user' => $owned_by_user,
                    'form' => $form->createView(),
                ));
    }

    public function lastAction(Request $request, Application $app)
    {
        return $app['twig']->render('document/last.html.twig');
    }

    public function bestAction(Request $request, Application $app)
    {
        return $app['twig']->render('document/best.html.twig');
    }
}