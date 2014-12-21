<?php
/**
 * Created by PhpStorm.
 * User: moniqueadamson
 * Date: 21/12/14
 * Time: 15:26
 */

namespace BookReview\BookBundle\Search;

use Emhar\SearchDoctrineBundle\Item\AbstractItem;
use Emhar\SearchDoctrineBundle\Mapping\Annotation\Hit;
use Emhar\SearchDoctrineBundle\Mapping\Annotation\ItemEntity;

/**
 * @ItemEntity(
 *  identifier="book",
 *  label="Book List",
 *  entityClass="BookReview\BookBundle\Entity\Book"
 * )
 */
class SearchItem extends AbstractItem {


    protected $id;
    protected $title;
    protected $author;
    protected $genre;
    protected $publisher;

    /**
     * Construct Resource
     *
     * @Hit(identifier="id", scoreFactor=0, sortable=false, label="ID", mapping={
     *  "book"="id",
     * })
     * @Hit(identifier="title", scoreFactor=1, sortable=false, label="Title", mapping={
     *  "book"="title",
     * })
     * @Hit(identifier="author", scoreFactor=2, sortable=false, label="Author", mapping={
     *  "book"="author",
     * })
     * @Hit(identifier="genre", scoreFactor=3, sortable=false, label="Author", mapping={
     *  "book"="genre",
     * })
     * @Hit(identifier="publisher", scoreFactor=4, sortable=false, label="Publisher", mapping={
     *  "book"="publisher",
     * })
     */
    public function __construct($id, $title, $author, $genre, $publisher)
    {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->genre = $genre;
        $this->publisher = $publisher;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @param mixed $genre
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    /**
     * @return mixed
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * @param mixed $publisher
     */
    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;
    }

}