<?php

namespace BookReview\BookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function indexAction()
    {
        return $this->render('BookReviewBookBundle:Page:index.html.twig', array(
                // ...
            ));    }

}
