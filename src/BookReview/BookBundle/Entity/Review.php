<?php

namespace BookReview\BookBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
/**
 * Review
 *
 * @ORM\Table(name="assignment_review")
 * @ORM\Entity(repositoryClass="BookReview\BookBundle\Entity\ReviewRepository")
 * @ExclusionPolicy("all")
 */
class Review
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
	 * @Expose
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
	 * @Expose
     */
    private $username;

    /**
     * @var \BookReview\BookBundle\Entity\Book
     * @ORM\ManyToOne(targetEntity="BookReview\BookBundle\Entity\Book", inversedBy="reviews")
     * @ORM\JoinColumn(name="book_id", referencedColumnName="id")
	 * @Expose
     */
    private $book;

    /**
     * @var string
     *
     * @ORM\Column(name="review", type="text")
	 * @Expose
     */
    private $review;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecreated", type="datetime")
     */
    private $datecreated;

    /**
     * @var integer
     *
     * @ORM\Column(name="rating", type="integer", nullable=true)
	 * @Expose
     */
    private $rating;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return Review
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set bookid
     *
     * @param string $bookid
     * @return Review
     */
    public function setBookid($bookid)
    {
        $this->bookid = $bookid;

        return $this;
    }

    /**
     * Get bookid
     *
     * @return string 
     */
    public function getBookid()
    {
        return $this->bookid;
    }

    /**
     * Set review
     *
     * @param string $review
     * @return Review
     */
    public function setReview($review)
    {
        $this->review = $review;

        return $this;
    }

    /**
     * Get review
     *
     * @return string 
     */
    public function getReview()
    {
        return $this->review;
    }

    /**
     * Set datecreated
     *
     * @param \DateTime $datecreated
     * @return Review
     */
    public function setDatecreated($datecreated)
    {
        $this->datecreated = $datecreated;

        return $this;
    }

    /**
     * Get datecreated
     *
     * @return \DateTime 
     */
    public function getDatecreated()
    {
        return $this->datecreated;
    }

    /**
     * Set book
     *
     * @param \BookReview\BookBundle\Entity\Book $book
     * @return Review
     */
    public function setBook(\BookReview\BookBundle\Entity\Book $book = null)
    {
        $this->book = $book;

        return $this;
    }

    /**
     * Get book
     *
     * @return \BookReview\BookBundle\Entity\Book 
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * Set rating
     *
     * @param integer $rating
     * @return Review
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return integer 
     */
    public function getRating()
    {
        return $this->rating;
    }
}
