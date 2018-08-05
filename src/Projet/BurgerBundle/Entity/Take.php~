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
     * @var integer
     *
     * @ORM\Column(name="id_gb", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idGb;

    /**
     * @var \Product
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
     * @return \Product
     */
    public function getIdProduct()
    {
        return $this->idProduct;
    }

    /**
     * @param \Product $idProduct
     */
    public function setIdProduct($idProduct)
    {
        $this->idProduct = $idProduct;
    }

    /**
     * @param int $idGb
     */
    public function setIdGb($idGb)
    {
        $this->idGb = $idGb;
    }

    /**
     * @return int
     */
    public function getIdGb()
    {
        return $this->idGb;
    }


}

