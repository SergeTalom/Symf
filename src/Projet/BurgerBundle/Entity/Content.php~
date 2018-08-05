<?php

namespace Projet\BurgerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Content
 *
 * @ORM\Table(name="content", indexes={@ORM\Index(name="FK_content", columns={"id_cart"})})
 * @ORM\Entity
 */
class Content
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_product", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idProduct;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * @var \Cart
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Cart")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_cart", referencedColumnName="id_cart")
     * })
     */
    private $idCart;

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }


}

