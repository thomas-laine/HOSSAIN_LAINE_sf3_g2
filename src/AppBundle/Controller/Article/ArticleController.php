<?php

namespace AppBundle\Controller\Article;

use AppBundle\Entity\Article\Tag;
use AppBundle\Form\Type\Article\ArticleType;
use AppBundle\Form\Type\Article\TagType;
use AppBundle\Form\Type\Article\ArticleUpdate;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends Controller
{
    /**
     * @Route("/list", name="article_list")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $articleRepository = $em->getRepository('AppBundle:Article\Article');

        $articles = $articleRepository->findAll();

        return $this->render("AppBundle:Article:index.html.twig", [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/list?", name="article_tag")
     *
     * @return Response
     */
    public function showArticleTag(Request $request)
    {
        $tag = $request->query->get('tag');

        $em = $this->getDoctrine()->getManager();
        $tagRepository = $em->getRepository('AppBundle:Article\Article');

        $articles = $tagRepository->findBy([
            'tag' => $tag,
        ]);

        return $this->render('AppBundle:Article:index.html.twig', [
            'articles' => $articles,
        ]);
    }


    /**
     * @Route("/show/{id}", requirements={"id" = "\d+"}, name="article_id")
     *
     * @return Response
     */
    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $idRepository = $em->getRepository('AppBundle:Article\Article');

        $articles = $idRepository->findBy([
            'id' => $id,
        ]);

        return $this->render('AppBundle:Article:index.html.twig', [
            'articles' => $articles,
        ]);

    }

    /**
     * @Route("/show/{articleName}")
     *
     * @param $articleName
     *
     * @return Response
     */
    public function showArticleNameaction($articleName)
    {
        return $this->render('AppBundle:Article:index.html.twig', [
            'articleName' => $articleName,
        ]);
    }

    /**
     * @Route("/author", name="article_author")
     *
     *
     * @return Response
     */
    public function authorAction(Request $request)
    {
        $author = $request->query->get('author');

        $em = $this->getDoctrine()->getManager();
        $articleRepository = $em->getRepository('AppBundle:Article\Article');

        $articles = $articleRepository->findBy([
            'author' => $author,
        ]);

        return $this->render('AppBundle:Article:index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/tag/new")
     */


    public function newAction(Request $request)
    {
        $form = $this->createForm(TagType::class);

        $form->handleRequest($request);


        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            /** @var Tag $slug */
            $tag = $form->getData();


            $stringUtil = $this->get('string.util');
            $slug = $stringUtil->slugify($tag->getName());
            $tag->setSlug($slug);

            $em->persist($tag);
            $em->flush();

            return $this->redirectToRoute('article_list');
        }

        return $this->render('AppBundle:Article:tag.new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/new", name="article_new")
     */
    public function newArticleAction(Request $request)
    {
        $form = $this->createForm(ArticleType::class);

        $form->handleRequest($request);


        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $article = $form->getData();


            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('article_list');
        }

        return $this->render('AppBundle:Article:article.new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/del", name="article_del")
     *
     * @return Response
     */
    public function delArticleAction(Request $request)
    {
        $id = $request->query->get('id');
        $em = $this->getDoctrine()->getManager();
        $articleDel = $em->getRepository('AppBundle:Article\Article');

        $articles = $articleDel->findOneBy([
            'id' => $id,
        ]);

        $em->remove($articles);
        $em->flush();
        return $this->redirectToRoute('article_list');

    }

    /**
     * @Route("/update", name="article_update")
     *
     * @return Response
     */
    public function updateArticleAction( Request $request)
    {
        $id = $request->query->get('id');
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('AppBundle:Article\Article')->find($id);
        if (!$news) {
            throw $this->createNotFoundException(
                'No news found for id ' . $id
            );
        }

        $form = $this->createFormBuilder($news)
            ->add('title')
            ->add('content')
            ->add('author')
            ->add('tag')
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('article_list');
        }

        $build['form'] = $form->createView();

        return $this->render('AppBundle:Article:article.update.html.twig', $build);
    }

}