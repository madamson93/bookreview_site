<?php

namespace BookReview\BookBundle\Controller;

use BookReview\BookBundle\Entity\Book;
use BookReview\BookBundle\Form\BookType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BookController extends Controller
{
    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $book = $em->getRepository('BookReviewBookBundle:Book')->find($id);

        $reviews = $em->getRepository('BookReviewBookBundle:Review')
                      ->getReviewsforBook($book->getId());

        return $this->render('BookReviewBookBundle:Book:view.html.twig', array(
                'book' => $book,
                'reviews' => $reviews
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

            return $this->redirect($this->generateUrl('bookreview_books_view', array(
                'id' => $book->getId()
            )));
        }

        return $this->render('BookReviewBookBundle:Book:create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $book = $em->getRepository('BookReviewBookBundle:Book')->find($id);
        $form = $this->createForm(new BookType(), $book, array(
           'action' => $request->getUri()
        ));

        $form->handleRequest($request);

        if($form->isValid()){
            $em->flush();
            return $this->redirect($this->generateUrl('bookreview_books_view', array(
                'id' => $book->getId()
            )));
        }

        return $this->render('BookReviewBookBundle:Book:edit.html.twig', array(
            'form' => $form->createView(),
            'book' => $book
        ));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $book = $em->getRepository('BookReviewBookBundle:Book')->find($id);
        $em->remove($book);
        $em->flush();
        return $this->redirect($this->generateUrl('bookreview_home'));
    }

}
