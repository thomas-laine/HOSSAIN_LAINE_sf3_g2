<?php

namespace AppBundle\Controller\Movie;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class MovieController extends Controller
{
    /**
     * @Route("/list")
     */
    public function listAction()
    {
        return new Response('List of movies');
    }

    /**
     * @Route("/show/{id}", requirements={"id" = "\d+"})
     */
    public function showAction($id, Request $request)
    {
        $tag = $request->query->get('tag');

        return new Response(
            'Affiche moi le film avec l\'id: '.$id.' avec le tag'.$tag
        );
    }

}