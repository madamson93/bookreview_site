<?php

namespace BookReview\BookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $books = $em->getRepository('BookReviewBookBundle:Book')
                    ->getBooks(20, 0);

        return $this->render('BookReviewBookBundle:Page:index.html.twig', array(
            'books' => $books
        ));
    }

    public function aboutAction()
    {
        return $this->render('BookReviewBookBundle:Page:about.html.twig', array(// ...
        ));
    }

}
