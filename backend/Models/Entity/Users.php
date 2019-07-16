<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity
 */
class Users
{
    /**
     * @var integer
     *
     * @ORM\Column(name="matr", type="integer",unique=true)
     * @ORM\Id
     * 
     */
    private $matr;

  	  /**
	   * @var string $nome 
       * @ORM\Column(name="name", type="string", length=255,nullable=true)
	   */
    private $nome = null;

     /**
	   *  @var string $tag
       *  @ORM\Column(name="tag", type="string", length=255,nullable=true)
	   */
      private $tag = null;

}
