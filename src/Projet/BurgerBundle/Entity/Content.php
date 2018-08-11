<?php

namespace Projet\BurgerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Content
 *
 * @ORM\Table(name="content", indexes={@ORM\Index(name="FK_content", columns={"id_cart"})})
 * @ORM\Entity(repositoryClass="Projet\BurgerBundle\Repository\ContentRepository")
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



    /**
     * Set idProduct
     *
     * @param integer $idProduct
     *
     * @return Content
     */
    public function setIdProduct($idProduct)
    {
        $this->idProduct = $idProduct;

        return $this;
    }

    /**
     * Get idProduct
     *
     * @return integer
     */
    public function getIdProduct()
    {
        return $this->idProduct;
    }

    /**
     * Set idCart
     *
     * @param \Projet\BurgerBundle\Entity\Cart $idCart
     *
     * @return Content
     */
    public function setIdCart(\Projet\BurgerBundle\Entity\Cart $idCart)
    {
        $this->idCart = $idCart;

        return $this;
    }

    /**
     * Get idCart
     *
     * @return \Projet\BurgerBundle\Entity\Cart
     */
    public function getIdCart()
    {
        return $this->idCart;
    }
}
