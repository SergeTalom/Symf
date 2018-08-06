<?php

namespace Projet\BurgerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Take
 *
 * @ORM\Table(name="take", indexes={@ORM\Index(name="FK_content", columns={"id_product"})})
 * @ORM\Entity
 */
class Take
{
    /**
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Goodburger")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_gb", referencedColumnName="id_gb")
     * })
     */
    private $idGb;

    /**
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_product", referencedColumnName="id_product")
     * })
     */
    private $idProduct;

    /**
     * @return \Projet\BurgerBundle\Entity\Product
     */
    public function getIdProduct()
    {
        return $this->idProduct;
    }

    /**
     * @param \Projet\BurgerBundle\Entity\Product $idProduct
     */
    public function setIdProduct($idProduct)
    {
        $this->idProduct = $idProduct;
    }

    /**
     * @param \Projet\BurgerBundle\Entity\Goodburger $idGb
     */
    public function setIdGb($idGb)
    {
        $this->idGb = $idGb;
    }

    /**
     * @return \Projet\BurgerBundle\Entity\Goodburger
     */
    public function getIdGb()
    {
        return $this->idGb;
    }


}
