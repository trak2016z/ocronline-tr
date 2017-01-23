<?php

namespace OCROnline\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use OCROnline\Form\DocumentType;

class ShowController
{
    public function imageAction(Request $request, Application $app, $id, $thumbnail = false)
    {
        $em = $app['orm.em'];
        $document = $em->find("OCROnline\Entity\Document", $id);
        if (!$document) {
            $app->abort(404, 'Dokument nie istnieje.');
        }

        $token = $app['security.token_storage']->getToken();
        $user = $token->getUser();

        $auth_check = $app['security.authorization_checker'];

        $allowed = ($document->getPrivacy() != 2) || ( $auth_check->isGranted('ROLE_USER')
                           && ( $auth_check->isGranted('ROLE_ADMIN')
                           || ($user->getId() == $document->getUser()->getId()) ));

        if (!$allowed) {
            $app->abort(403, 'Brak uprawnień.');
        }
        
        $source = null;
        $mimetype = null;
        if ($thumbnail) { 
            $source = $document->getThumbnail();
            $mimetype = "image/jpeg";
        } else {
            $source = $document->getFileContent();
            $mimetype = $document->getMimeType();
        }
        return new Response(stream_get_contents($source), 200, array(
            "Content-Type" => $mimetype,
        ));
    }
    public function thumbnailAction(Request $request, Application $app, $id)
    {
        return $this->imageAction($request, $app, $id, true);
    }
}