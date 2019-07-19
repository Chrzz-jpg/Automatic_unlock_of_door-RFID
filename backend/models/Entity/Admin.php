<?php

namespace Entity;

use App\Auth\Bcrypt;

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
	   * @var string $password 
       * @ORM\Column(name="password", type="string", length=100,nullable=true)
	   */
    private $password ;

   
    /**
     *  @var Users[]
     * @ORM\ManyToOne(targetEntity="Entity\Users")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

     /**
     * Constructor
     */
    public function __construct(Array $data = [])
    {
        if (!empty($data['user']))
        $this->setUser($data['user']);

        if (!empty($data['password'])) {
            $bcrypt = new Bcrypt();
            $this->password = $bcrypt->setHash($data['password']);
        }
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
     * Set password.
     *
     * @param string|null $password
     *
     * @return Admin
     */
    public function setPassword($password = null)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password.
     *
     * @return string|null
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set user.
     *
     * @param \Entity\Users|null $user
     *
     * @return Admin
     */
    public function setUser(\Entity\Users $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \Entity\Users|null
     */
    public function getUser()
    {
        return $this->user;
    }


    public function __toArray()
    {
        $data = [];
        foreach ($this as $k=>$v)
        $data[$k] = $v;

        return $data;
    }

}
