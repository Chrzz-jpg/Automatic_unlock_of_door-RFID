<?php

namespace Entity;


use Doctrine\ORM\Mapping as ORM;
use Entity\Users;
/**
 * Cliente
 *
 * @ORM\Table(name="admin")
 * @ORM\Entity
 */
class Admin
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

  	  /**
	   * @var string $pass 
       * @ORM\Column(name="pass", type="string", length=255,nullable=true)
	   */
    private $pass = null;

    /**
     * @var Users[]
    * 
    * @ORM\OneToMany( targetEntity="Users", mappedBy="matr")
    */
    private $users;

  

}
