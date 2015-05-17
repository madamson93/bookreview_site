<?php

namespace BookReview\BookBundle\Controller;

use BookReview\BookBundle\Entity\Book;
use BookReview\BookBundle\Form\BookType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BookReview\BookBundle\Search\SearchItem;
use GuzzleHttp\Client;

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

			$form_title = $form->get('title')->getData();

			$client = new Client();
			$request = $client->createRequest('GET', 'https://www.googleapis.com/books/v1/volumes');

			$query = $request->getQuery();
			$query->set('q', $form_title);
			$query->set('maxResults', '1');

			$response = $client->send($request)->json();
			$book_info = $response['items'][0]['volumeInfo'];

			$pageCount = $book_info['pageCount'];
			$publishedDate = $book_info['publishedDate'];
			$isbn = $book_info['industryIdentifiers'][0]['identifier'];

			if ($pageCount){
				$book->setPageCount($pageCount);
			};

			if ($publishedDate){
				$book->setPublishedDate($publishedDate);
			};

			if ($isbn){
				$book->setIsbn($isbn);
			};

            //uses custom service to persist data
            $this->get("book_review_book.data")->saveData($book);

            return $this->redirect($this->generateUrl('bookreview_books_view', array(
                'id' => $book->getId(),
            )));
        }

        return $this->render('BookReviewBookBundle:Book:create.html.twig', array(
            'form' => $form->createView(),
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
        $repository = $this->getDoctrine()->getRepository('BookReviewBookBundle:Book');
        $books = $repository->findBookByGenre($query);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $books,
            $this->get('request')->query->get('page', 1),
            10
        );

        return $this->render('BookReviewBookBundle:Book:filter.html.twig', array(
            'pagination' => $pagination
        ));

    }

    public function searchAction(Request $request){

		$defaultData = array('message' => 'Type your search term');
		$form = $this->createFormBuilder($defaultData)
			->add('Search_term', 'text')
			->getForm();

        $form->handleRequest($request);

        if ($form->isValid())
        {
			$search_term = $form->get('Search_term')->getData();

			$client = new Client();
			$request = $client->createRequest('GET', 'https://www.googleapis.com/books/v1/volumes');

			$query = $request->getQuery();
			$query->set('q', $search_term);

			$response = $client->send($request)->json();

			$items = $response['items'];

            return $this->render('BookReviewBookBundle:Search:form.html.twig', array(
                'form' => $form->createView(),
				'items' => $items
            ));

        }

        return $this->render('BookReviewBookBundle:Search:form.html.twig', array(
            'form' => $form->createView()
        ));

    }

	public function resultAction($item_title){

		$search_term = $item_title;

		$client = new Client();
		$request = $client->createRequest('GET', 'https://www.googleapis.com/books/v1/volumes');

		$query = $request->getQuery();
		$query->set('q', $search_term);

		$response = $client->send($request)->json();

		$item = $response['items'][0];

		return $this->render('BookReviewBookBundle:Search:results.html.twig', array(
			'item' => $item
		));

	}


}
