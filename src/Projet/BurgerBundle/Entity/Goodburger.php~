<?php

namespace Projet\BurgerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Goodburger
 *
 * @ORM\Table(name="goodburger")
 * @ORM\Entity
 */
class Goodburger
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_gb", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idGb;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=254, nullable=false)
     */
    private $location;

    /**
     * @return int
     */
    public function getIdGb()
    {
        return $this->idGb;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param int $idGb
     */
    public function setIdGb($idGb)
    {
        $this->idGb = $idGb;
    }

    /**
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }


}

