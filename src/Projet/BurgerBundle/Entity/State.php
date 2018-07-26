<?php

namespace Projet\BurgerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * State
 *
 * @ORM\Table(name="state")
 * @ORM\Entity
 */
class State
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_state", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idState;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=254, nullable=false)
     */
    private $state;

    /**
     * @return int
     */
    public function getIdState()
    {
        return $this->idState;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param int $idState
     */
    public function setIdState($idState)
    {
        $this->idState = $idState;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }


}

