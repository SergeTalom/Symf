<?php

namespace Projet\BurgerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Type
 *
 * @ORM\Table(name="type")
 * @ORM\Entity
 */
class Type
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_type", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idType;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=254, nullable=false)
     */
    private $type;

    /**
     * @return int
     */
    public function getIdType()
    {
        return $this->idType;
    }

    /**
     * @param int $idType
     */
    public function setIdType($idType)
    {
        $this->idType = $idType;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }


}

