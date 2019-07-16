<?php
namespace Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cliente
 *
 * @ORM\Table(name="logs")
 * @ORM\Entity
 */
class Logs {
 /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @var Users[]
    * 
    * @ORM\OneToMany( targetEntity="Users", mappedBy="matr")
    */
    private $users;

    /** @ORM\Column(type="datetime") */
    private $indate;
    
}