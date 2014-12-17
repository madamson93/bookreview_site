<?php

namespace BookReview\BookBundle\Controller;

use BookReview\BookBundle\Entity\Book;
use BookReview\BookBundle\Form\BookType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BookController extends Controller
{
    public function viewAction()
    {
        return $this->render('BookReviewBookBundle:Book:view.html.twig', array(
                // ...
        ));
    }

    public function createAction(Request $request)
    {
        $book = new Book();

        $form = $this->createForm(new BookType(), $book, array(
            'action' => $request->getUri()
        ));

        $form->handleRequest($request);

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();
        }

        return $this->render('BookReviewBookBundle:Book:create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editAction()
    {
        return $this->render('BookReviewBookBundle:Book:edit.html.twig', array(
                // ...
        ));
    }

    public function deleteAction()
    {
        return $this->render('BookReviewBookBundle:Book:delete.html.twig', array(
                // ...
        ));
    }

}
