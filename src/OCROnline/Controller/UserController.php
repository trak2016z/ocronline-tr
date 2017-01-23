<?php

namespace OCROnline\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use OCROnline\Form\DocumentUploadType;
use Doctrine\Common\Collections\Criteria;

class UserController
{
    public function indexAction(Request $request, Application $app)
    {
        $document = new \OCROnline\Entity\Document();
        $form = $app['form.factory']->createBuilder(DocumentUploadType::class, $document)->getForm();
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

    public function showAction(Request $request, Application $app, $user_id)
    {
        $em = $app['orm.em'];
        $token = $app['security.token_storage']->getToken();
        $owner = $em->find('OCROnline\Entity\User', $user_id);
        $user = $token->getUser();
        

        $auth_check = $app['security.authorization_checker'];

        $owned_by_user = $auth_check->isGranted('ROLE_ADMIN') || ($user->getId() == $owner->getId());

        if ($owned_by_user) {
            $documents = $owner->getDocuments();
        } else {
            $criteria = Criteria::create()
                            ->where(Criteria::expr()->eq("privacy", "0"))
            ;
            $documents = ($owner->getDocuments())->matching($criteria);
        }

        return $app['twig']->render('user/show.html.twig',
            array(
                'user' => $owner,
                'documents' => $documents,
            )
        );
    }
}