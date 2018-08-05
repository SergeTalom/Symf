<?php

namespace Projet\BurgerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Checkout
 *
 * @ORM\Table(name="checkout", indexes={@ORM\Index(name="FK_Checkout", columns={"id_user"})})
 * @ORM\Entity
 */
class Checkout
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_cart", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idCart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_out", type="datetime", nullable=false)
     */
    private $dateOut;

    /**
     * @var integer
     *
     * @ORM\Column(name="total_price", type="integer", nullable=false)
     */
    private $totalPrice;

    /**
     * @var \User
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    /**
     * @return \DateTime
     */
    public function getDateOut()
    {
        return $this->dateOut;
    }

    /**
     * @return int
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * @param \DateTime $dateOut
     */
    public function setDateOut($dateOut)
    {
        $this->dateOut = $dateOut;
    }

    /**
     * @param int $totalPrice
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;
    }

    /**
     * @param \User $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return \User
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @return int
     */
    public function getIdCart()
    {
        return $this->idCart;
    }

    /**
     * @param int $idCart
     */
    public function setIdCart($idCart)
    {
        $this->idCart = $idCart;
    }


}

