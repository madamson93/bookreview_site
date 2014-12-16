<?php

namespace BookReview\BookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BookController extends Controller
{
    public function viewAction()
    {
        return $this->render('BookReviewBookBundle:Book:view.html.twig', array(
                // ...
            ));    }

    public function createAction()
    {
        return $this->render('BookReviewBookBundle:Book:create.html.twig', array(
                // ...
            ));    }

    public function editAction()
    {
        return $this->render('BookReviewBookBundle:Book:edit.html.twig', array(
                // ...
            ));    }

    public function deleteAction()
    {
        return $this->render('BookReviewBookBundle:Book:delete.html.twig', array(
                // ...
            ));    }

}
