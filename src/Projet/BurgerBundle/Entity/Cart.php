<?php

namespace Projet\BurgerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cart
 *
 * @ORM\Table(name="cart", indexes={@ORM\Index(name="FK_have", columns={"id_user"})})
 * @ORM\Entity(repositoryClass="Projet\BurgerBundle\Repository\CartRepository")
 */
class Cart
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_cart", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCart;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    /**
     * @param int $idCart
     */
    public function setIdCart($idCart)
    {
        $this->idCart = $idCart;
    }

    /**
     * @return int
     */
    public function getIdCart()
    {
        return $this->idCart;
    }



    /**
     * Set idUser
     *
     * @param \Projet\BurgerBundle\Entity\User $idUser
     *
     * @return Cart
     */
    public function setIdUser(\Projet\BurgerBundle\Entity\User $idUser = null)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return \Projet\BurgerBundle\Entity\User
     */
    public function getIdUser()
    {
        return $this->idUser;
    }
}
