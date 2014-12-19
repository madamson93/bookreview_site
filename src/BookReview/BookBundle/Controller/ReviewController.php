<?php

namespace BookReview\BookBundle\Controller;

use BookReview\BookBundle\Entity\Review;
use BookReview\BookBundle\Form\ReviewType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReviewController extends Controller
{
    public function createAction($book_id, Request $request)
    {
        $book = $this->getBook($book_id);

        $review = new Review();

        $form = $this->createForm(new ReviewType(), $review, array(
            'action' => $request->getUri()
        ));

        $form->handleRequest($request);

        if($form->isValid()){
            $review->setUsername($this->getUser()->getUsername());
            $review->setDatecreated(new \DateTime("now", new \DateTimeZone("Europe/London")));
            $review->setBook($book);

            //uses custom service to persist data
            $this->get("book_review_book.data")->saveData($review);

            return $this->redirect($this->generateUrl('bookreview_books_view', array(
                'id' => $book->getId()
            )));
        }

        return $this->render('BookReviewBookBundle:Review:create.html.twig', array(
             'form' => $form->createView(),
             'id' => $book->getId(),
             'title' => $book->getTitle()
        ));
    }

    protected function getBook($book_id){
        $em = $this->getDoctrine()->getManager();

        $book = $em->getRepository('BookReviewBookBundle:Book')->find($book_id);

        return $book;
    }

}
