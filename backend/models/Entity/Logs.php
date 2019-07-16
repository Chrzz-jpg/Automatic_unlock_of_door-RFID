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
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Add user.
     *
     * @param \Entity\Users $user
     *
     * @return Logs
     */
    public function addUser(\Entity\Users $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user.
     *
     * @param \Entity\Users $user
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeUser(\Entity\Users $user)
    {
        return $this->users->removeElement($user);
    }

    /**
     * Get users.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
