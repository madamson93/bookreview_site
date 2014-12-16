<?php
/**
 * Created by PhpStorm.
 * User: moniqueadamson
 * Date: 16/12/14
 * Time: 13:58
 */

namespace BookReview\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct( )
    {
        parent::__construct();

    }

}