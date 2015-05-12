<?php


namespace BookReview\APIBundle\Controller;

use BookReview\BookBundle\Entity\Book;
use BookReview\BookBundle\Form\BookType;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class BookController extends FOSRestController {

	public function getBooksAction(){

		$em = $this->getDoctrine()->getManager();

		$books = $em->getRepository('BookReviewBookBundle:Book')->findAll();

		return $this->handleView($this->view($books));
	}

	public function getBookAction($id){

		$em = $this->getDoctrine()->getManager();
		$book = $em->getRepository('BookReviewBookBundle:Book')->find($id);

		if(!$book) {
			//no blog post is found, so we set the view to no content and set the status code to 404
			$view = $this->view(null, 404);
		} else {
			//the blog post exists, so we pass it to the view and the status code defaults to 200 "OK"
			$view = $this->view($book);
		}

		return $this->handleView($view);
	}

	public function postBookAction(Request $request){
		//prepare the form and remove the submit button
		$book = new Book();
		$form = $this->createForm(new BookType(), $book);

		//check we can parse the POST data
		if($request->getContentType() != 'json' ){
			return $this->handleView($this->view(null, 400));
		}

		//json_decode the request content and pass it to the form
		$form->submit(json_decode($request->getContent(), true));

		//check that the POST data meets validations
		if($form->isValid()) {
			//uses custom service to persist data
			$this->get("book_review_book.data")->saveData($book);

			//set status code to 201 and set the location header to the URL to retrieve the blog post
			return $this->handleView($this->view(null, 201)
				->setLocation(
					$this->generateUrl('api_book_get_book',
						['id' => $book->getId()]
					)
				)
			);

		}
		else {
			//the form isn't valid so return the form along with a 400 status code
			return $this->handleView($this->view($form, 400));
		}
	}

	public function putBookAction($id, Request $request){
		$em = $this->getDoctrine()->getManager();
		$book = $em->getRepository('BookReviewBookBundle:Book')->find($id);

		//if post has not been found return a 404 error
		if(!$book instanceof Book){
			return $this->handleView($this->view(null, 404));
		}

		//check we can parse the data
		if($request->getContentType() != 'json' ){
			return $this->handleView($this->view(null, 400));
		}

		$form = $this->createForm(new BookType(), $book);

		//json_decode the request content and pass it to the form
		$form->submit(json_decode($request->getContent(), true));

		if($form->isValid()){
			//if the form is valid then persist the updated data
			$em->flush();
			return $this->handleView($this->view(null, 204));
		} else {
			//the form isn't valid so return the form along with a 400 status code
			return $this->handleView($this->view($form, 400));
		}


	}

	public function deleteBookAction($id){

		$em = $this->getDoctrine()->getManager();
		$book = $em->getRepository('BookReviewBookBundle:Book')->find($id);

		if (!$book instanceof Book){
			return $this->handleView($this->view(null, 404));
		} else {

			$this->get('book_review_book.data')->deleteData($book);

			return $this->handleView($this->view(null, 204));
		}

	}


}