<?php

namespace OCROnline\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use OCROnline\Form\RecognizeType;
use OCROnline\Form\DocumentEditType;

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

        if (($document->getPrivacy() == 2) && !$owned_by_user) {
            $app->abort(403, 'Ten dokument jest prywatny.');
        }

        $form = $app['form.factory']->createBuilder(RecognizeType::class, $document)->getForm();

        $form_edit = $app['form.factory']->createBuilder(DocumentEditType::class, $document)->getForm();
        if ($owned_by_user) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $document->doRecognize();
                $em->persist($document);
                $em->flush();
            }

            $form_edit->handleRequest($request);
            if ($form_edit->isSubmitted() && $form_edit->isValid()) {
                $em->persist($document);
                $em->flush();
            }
        }

        return $app['twig']->render('document/show.html.twig',
                array(
                    'document' => $document,
                    'owned_by_user' => $owned_by_user,
                    'form' => $form->createView(),
                    'form_edit' => $form_edit->createView(),
                ));
    }

    public function lastAction(Request $request, Application $app)
    {
        $em = $app['orm.em'];
        $documents = $em->getRepository('OCROnline\Entity\Document')->findPublicOrderedByNewest();
        return $app['twig']->render('document/last.html.twig',
                                    array(
                                        'documents' => $documents,
                                    ));
    }

    public function bestAction(Request $request, Application $app)
    {
        return $app['twig']->render('document/best.html.twig');
    }
}