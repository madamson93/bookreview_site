<?php


namespace BookReview\APIBundle\Controller;

use BookReview\BookBundle\Entity\Book;
use BookReview\BookBundle\Entity\Review;
use BookReview\BookBundle\Form\BookType;
use BookReview\BookBundle\Form\ReviewType;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

class ReviewController extends FOSRestController {

	public function getReviewsAction($slug){

		$em = $this->getDoctrine()->getManager();
		$book = $em->getRepository('BookReviewBookBundle:Book')->find($slug);
		$reviews = $em->getRepository('BookReviewBookBundle:Review')
			->getReviewsforBook($book->getId());

		if(!$book) {
			//no blog post is found, so we set the view to no content and set the status code to 404
			$view = $this->view(null, 404);
		} else {
			//the blog post exists, so we pass it to the view and the status code defaults to 200 "OK"
			$view = $this->view($reviews);
		}

		return $this->handleView($view);
	}

	public function getReviewAction($slug, $id){
		$em = $this->getDoctrine()->getManager();
		$book = $em->getRepository('BookReviewBookBundle:Book')->find($slug);

		$review =
			$em->getRepository('BookReviewBookBundle:Review')
				->getReviewforBook($book->getId(), $id);

		if(!$book) {
			//no book is found, so we set the view to no content and set the status code to 404
			$view = $this->view(null, 404);

		} else {
			//the blog post exists, so we pass it to the view and the status code defaults to 200 "OK"
			$view = $this->view($review);
		}

		return $this->handleView($view);


	}

	public function postReviewsAction($slug, Request $request){

		//find the book which is going to have a new review
		$em = $this->getDoctrine()->getManager();
		$book = $em->getRepository('BookReviewBookBundle:Book')->find($slug);

		//prepare the form and remove the submit button
		$review = new Review();
		$form = $this->createForm(new ReviewType(), $review);

		//check we can parse the POST data
		if($request->getContentType() != 'json' ){
			return $this->handleView($this->view(null, 400));
		}

		//json_decode the request content and pass it to the form
		$form->submit(json_decode($request->getContent(), true));

		//check that the POST data meets validations
		if($form->isValid()) {
			//populate review form fields with logged in user, book ID, new timestamp, persist and flush data
			$review->setUsername($request->get("username"));
			$review->setBook($book);
			$review->setBookid($slug);
			$review->setDatecreated(new \DateTime("Europe/London"));
			$this->get("book_review_book.data")->saveData($review);

			//set status code to 201 and set the location header to the URL to retrieve the blog post
			return $this->handleView($this->view(null, 201)
				->setLocation(
					$this->generateUrl('api_review_get_book_review',
						['slug' => $slug, 'id' => $review->getId()]
					)
				)
			);

		}
		else {
			//the form isn't valid so return the form along with a 400 status code
			return $this->handleView($this->view($form, 400));
		}
	}

	public function putReviewAction($slug, $id, Request $request){
		$em = $this->getDoctrine()->getManager();
		$book = $em->getRepository('BookReviewBookBundle:Book')->find($slug);

		$review =
			$em->getRepository('BookReviewBookBundle:Review')
				->getReviewforBook($book->getId(), $id);

		//gets first item in the array of reviews returned, being one
		$review = $review[0];

		//if review has not been found return a 404 error
		if(!$review){
			return $this->handleView($this->view(null, 404));
		}

		//check we can parse the data
		if($request->getContentType() != 'json' ){
			return $this->handleView($this->view(null, 400));
		}

		$form = $this->createForm(new ReviewType(), $review);

		//json_decode the request content and pass it to the form
		$form->submit(json_decode($request->getContent(), true));

		if($form->isValid()){
			//if the form is valid then persist the updated data
			$review->setUsername($request->get("username"));
			$review->setDatecreated(new \DateTime("Europe/London"));
			$em->persist($review);
	 		$em->flush();

			return $this->handleView($this->view(null, 204));
		} else {
			//the form isn't valid so return the form along with a 400 status code
			return $this->handleView($this->view($form, 400));
		}

	}

	public function deleteReviewAction($slug, $id){
		$em = $this->getDoctrine()->getManager();
		$book = $em->getRepository('BookReviewBookBundle:Book')->find($slug);

		$review =
			$em->getRepository('BookReviewBookBundle:Review')
				->getReviewforBook($book->getId(), $id);

		$review = $review[0];

		if (!$review){
			return $this->handleView($this->view(null, 404));
		} else {

			$this->get('book_review_book.data')->deleteData($review);

			return $this->handleView($this->view(null, 204));
		}
	}

}