<?php

namespace OCROnline\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use OCROnline\Form\DocumentType;

class ShowController
{
    public function imageAction(Request $request, Application $app, $id)
    {
        $em = $app['orm.em'];
        $document = $em->find("OCROnline\Entity\Document", $id);
        if (!$document) {
            $app->abort(404, 'Dokument nie istenieje.');
        }

        return new Response(stream_get_contents($document->getFileContent()), 200, array(
            "Content-Type" => $document->getMimeType(),
        ));
    }
}