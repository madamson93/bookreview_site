<?php

namespace BookReview\BookBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Iphp\FileStoreBundle\Mapping\Annotation as FileStore;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
/**
 * @ORM\Table(name="assignment_books")
 * @ORM\Entity(repositoryClass="BookReview\BookBundle\Entity\BookRepository")
 * @FileStore\Uploadable
 * @ExclusionPolicy("all")
 */
class Book
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
     * @ORM\Column(name="title", type="string", length=255)
	 * @Expose
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
	 * @Expose
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="genre", type="string", length=255)
	 * @Expose
     */
    private $genre;

    /**
     * @var string
     *
     * @ORM\Column(name="publisher", type="string", length=255)
	 * @Expose
     */
    private $publisher;

    /**
     * @var string
     *
     * @ORM\Column(name="summary", type="text")
	 * @Expose
     */
    private $summary;

    /**
     * @var array
     * @ORM\OneToMany(targetEntity="BookReview\BookBundle\Entity\Review", mappedBy="book")
     */
    private $reviews;

    /**
     * @ORM\Column(type="array", nullable=true)
     * @Assert\Image( maxSize="20M")
     * @FileStore\UploadableField(mapping="book_image")
     **/
    private $photo;


	/**
	 * @var integer
	 *
	 * @ORM\Column(name="pageCount", type="integer", nullable=true))
	 *
	 */
	private $pageCount;


	/**
	 * @var string
	 *
	 * @ORM\Column(name="publishedDate", type="string", length=255, nullable=true))
	 */
	private $publishedDate;


	/**
	 * @var string
	 *
	 * @ORM\Column(name="isbn", type="string", length=255, nullable=true))
	 * @Expose
	 */
	private $isbn;

	/**
	 * @return string
	 */
	public function getIsbn()
	{
		return $this->isbn;
	}

	/**
	 * @param string $isbn
	 */
	public function setIsbn($isbn)
	{
		$this->isbn = $isbn;
	}

	/**
	 * @return string
	 */
	public function getPublishedDate()
	{
		return $this->publishedDate;
	}

	/**
	 * @param string $publishedDate
	 */
	public function setPublishedDate($publishedDate)
	{
		$this->publishedDate = $publishedDate;
	}




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
     * Set title
     *
     * @param string $title
     * @return Book
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Book
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set genre
     *
     * @param string $genre
     * @return Book
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return string 
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set publisher
     *
     * @param string $publisher
     * @return Book
     */
    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * Get publisher
     *
     * @return string 
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * Set summary
     *
     * @param string $summary
     * @return Book
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->reviews = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add reviews
     *
     * @param \BookReview\BookBundle\Entity\Review $reviews
     * @return Book
     */
    public function addReview(\BookReview\BookBundle\Entity\Review $reviews)
    {
        $this->reviews[] = $reviews;

        return $this;
    }

    /**
     * Remove reviews
     *
     * @param \BookReview\BookBundle\Entity\Review $reviews
     */
    public function removeReview(\BookReview\BookBundle\Entity\Review $reviews)
    {
        $this->reviews->removeElement($reviews);
    }

    /**
     * Get reviews
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

	/**
	 * @return string
	 */
	public function getPageCount()
	{
		return $this->pageCount;
	}

	/**
	 * @param string $pageCount
	 */
	public function setPageCount($pageCount)
	{
		$this->pageCount = $pageCount;
	}
}
