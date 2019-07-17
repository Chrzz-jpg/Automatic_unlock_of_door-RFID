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
     * @ORM\Column(name="id", type="integer",unique=true)
     * @ORM\Id
     * 
     */
    private $id;

    /**
     * @var string $nome 
     * @ORM\Column(name="name", type="string", length=255,nullable=true)
     */
    private $nome = null;

    /**
     * @var string $orientador 
     * @ORM\Column(name="orientador", type="string", length=255,nullable=true)
     */
    private $orientador = null;


    /**
     *  @var string $tagId
     *  @ORM\Column(name="tagId", unique=true, type="string", length=255,nullable=true)
     */
    private $tagId = null;


    /**
     * Set id.
     *
     * @param int $id
     *
     * @return Users
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Set nome.
     *
     * @param string|null $nome
     *
     * @return Users
     */
    public function setNome($nome = null)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome.
     *
     * @return string|null
     */
    public function getNome()
    {
        return $this->nome;
    }


    /**
     * Set tagId.
     *
     * @param string|null $tagId
     *
     * @return Users
     */
    public function setTagId($tagId = null)
    {
        $this->tagId = $tagId;

        return $this;
    }

    /**
     * Get tagId.
     *
     * @return string|null
     */
    public function getTagId()
    {
        return $this->tagId;
    }



    /**
     * @return models\Entity\Users
     */
    public function getValues()
    {
        return get_object_vars($this);
    }

    /**
     * Set orientador.
     *
     * @param string|null $orientador
     *
     * @return Users
     */
    
    public function setOrientador($orientador = null)
    {
        $this->orientador = $orientador;

        return $this;
    }

    /**
     * Get orientador.
     *
     * @return string|null
     */
    public function getOrientador()
    {
        return $this->orientador;
    }
}
