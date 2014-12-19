<?php
/**
 * Created by PhpStorm.
 * User: moniqueadamson
 * Date: 19/12/14
 * Time: 15:40
 */

namespace BookReview\BookBundle\Controller;

use Doctrine\ORM\EntityManager;

class DataController {

    /**
     * @param EntityManager $em
     */
    function __construct(EntityManager $em){
        $this->em = $em;
    }

    /**
     * @param $entity
     */
    public function saveData($entity){
        $this->em->persist($entity);
        $this->em->flush($entity);
    }

    /**
     * @param $entity
     */
    public function deleteData($entity){
        $this->em->remove($entity);
        $this->em->flush($entity);
    }
}