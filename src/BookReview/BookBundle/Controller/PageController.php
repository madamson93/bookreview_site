<?php

namespace BookReview\BookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('BookReviewBookBundle:Book');
        $books = $repository->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $books,
            $this->get('request')->query->get('page', 1)/*page number*/,
            4 /*limit per page*/
        );

        return $this->render('BookReviewBookBundle:Page:index.html.twig', array(
            'pagination' => $pagination
        ));
    }

    public function aboutAction()
    {
        return $this->render('BookReviewBookBundle:Page:about.html.twig', array(// ...
        ));
    }

}
