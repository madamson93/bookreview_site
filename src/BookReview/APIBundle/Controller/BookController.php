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
}