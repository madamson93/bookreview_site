<?php

namespace BookReview\BookBundle\Controller;

use BookReview\BookBundle\Entity\Book;
use BookReview\BookBundle\Form\BookType;
use BookReview\BookBundle\Search\SearchItem;
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
            'reviews' => $reviews,
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

            //uses custom service to persist data
            $this->get("book_review_book.data")->saveData($book);

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

        $this->get("book_review_book.data")->deleteData($book);

        return $this->redirect($this->generateUrl('bookreview_home'));
    }

    public function filterAction($query)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');

        $books = $em->getRepository('BookReviewBookBundle:Book')
                    ->findBookByGenre($query);

        return $this->render('BookReviewBookBundle:Book:filter.html.twig', array(
            'books' => $books
        ));

    }

    public function newAction(Request $request){
        $searchService = $this->get('emhar_search_doctrine.search_service');
        $form = $searchService->getForm(SearchItem::getClass(), $this->generateUrl('bookreview_books_search'));

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $items = $searchService->getResults(SearchItem::getClass(), $form);
            $pageCount = $searchService->getPageCount(SearchItem::getClass(), $form);
        }

        return $this->render('BookReviewBookBundle:Book:search.html.twig', array(
            'form' => $form->createView()
        ));
    }

}
