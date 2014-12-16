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
            ));    }

    public function createAction(Request $request)
    {
        //Create a new empty Book entity
        $book = new Book();

        //Create a form from the BookType class, validate it against the Book entity with fields
        //set the form action to the current URI/link
        $form = $this->createForm(new BookType(), $book,[
            'action' => $request->getUri() ]);

        //If the request is POST then populate the form
        $form->handleRequest($request);

        //check if the form is valid
        if($form->isValid()){
            //gets the doctrine entity manage
            $em = $this->getDoctrine()->getManager();

            //tells the manager you want to persist this book entry
            $em->persist($book);

            //commit all changes
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
