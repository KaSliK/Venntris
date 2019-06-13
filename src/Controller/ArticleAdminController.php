<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class ArticleAdminController extends AbstractController
{
    /**
     * @Route("/admin/article/new", name="admin_article_new")
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(ArticleFormType::class);


        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            /** @var Article $article */
            $article= $form->getData();
            $article->setAuthor($this->getUser());
            $article->setImageFilename('cyf1.png');

            $em->persist($article);
            $em->flush();

            $this->addFlash('success', 'Artykuł stworzony');

            return $this->redirectToRoute('admin_article_list');
        }

        return $this->render('article_admin/new.html.twig', [
            'articleForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/article/{id}/edit")
     */
    public function edit(Article $article)
    {
        if ($article->getAuthor() != $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('No access!');
        }
        dd($article);
    }

    /**
     * @Route("admin/article", name="admin_article_list")
     */
    public function list(ArticleRepository $articleRepo)
    {

        $articles = $articleRepo->findAll();

        return $this->render('article_admin/list.html.twig', [
            'articles' => $articles
        ]);

    }
}
