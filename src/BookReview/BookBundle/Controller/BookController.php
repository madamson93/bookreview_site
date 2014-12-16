<?php

namespace BookReview\BookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BookReview\BookBundle\Entity\Book;
use BookReview\BookBundle\Form\BookType;
use Symfony\Component\HttpFoundation\Request;

class BookController extends Controller
{
    public function viewAction()
    {
        $em = $this->getDoctrine()->getManager();

        $books = $em->getRepository('BookReviewBookBundle:Book')->findAll();

        return $this->render('BookReviewBookBundle:Book:view.html.twig', array(
            'books' => $books
            ));    }

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
