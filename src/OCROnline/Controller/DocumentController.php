<?php

namespace OCROnline\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

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

        return $app['twig']->render('document/show.html.twig',
                array(
                    'document' => $document,
                ));
    }
}