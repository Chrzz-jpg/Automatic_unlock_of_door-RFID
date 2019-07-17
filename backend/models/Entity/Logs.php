<?php
namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Entity\Users;
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
     * @ORM\ManyToOne(targetEntity="Entity\Users")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $matricula;

    /** @ORM\Column(type="datetime") */
    private $indate;
   

 

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set indate.
     *
     * @param \DateTime $indate
     *
     * @return Logs
     */
    public function setIndate($indate)
    {
        $this->indate = $indate;

        return $this;
    }

    /**
     * Get indate.
     *
     * @return \DateTime
     */
    public function getIndate()
    {
        return $this->indate;
    }

    /**
     * Set matricula.
     *
     * @param \Entity\Users|null $matricula
     *
     * @return Logs
     */
    public function setMatricula(\Entity\Users $matricula = null)
    {
        $this->matricula = $matricula;

        return $this;
    }

    /**
     * Get matricula.
     *
     * @return \Entity\Users|null
     */
    public function getMatricula()
    {
        return $this->matricula;
    }
}
