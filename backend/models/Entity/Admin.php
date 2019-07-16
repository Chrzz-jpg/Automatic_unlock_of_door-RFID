<?php

namespace Entity;


use Doctrine\ORM\Mapping as ORM;
use App\Entity\Users;
/**
 * Admin
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
     * Set pass.
     *
     * @param string|null $pass
     *
     * @return Admin
     */
    public function setPass($pass = null)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * Get pass.
     *
     * @return string|null
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Add user.
     *
     * @param \Entity\Users $user
     *
     * @return Admin
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
