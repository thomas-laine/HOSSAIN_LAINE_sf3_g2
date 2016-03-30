<?php


namespace AppBundle\Controller\Picture;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PictureController extends Controller
{
    /**
     * @Route("/list")
     *
     */
    public function listAction()
    {
        return new Response('List of the pictures');
    }




    /**
     *
     * @Route("/show/{id}", requirements={"id" = "\d+"})
     *
     */
    public function showAction($id, Request $request)
    {
        //dump($request);die;

        $tag = $request->query->get('tag');

        return new Response(
            'Affiche moi l\'image avec l\'id: '.$id.', avec le tag '.$tag
        );
    }
}