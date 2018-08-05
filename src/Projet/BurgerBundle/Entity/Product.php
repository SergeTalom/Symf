<?php

namespace Projet\BurgerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * Product
 *
 * @ORM\Table(name="product", indexes={@ORM\Index(name="FK_can_be", columns={"id_state"}), @ORM\Index(name="FK_may_be", columns={"id_type"})})
 * @ORM\Entity(repositoryClass="Projet\BurgerBundle\Repository\ProductRepository")
 */
class Product
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_product", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProduct;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=254, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=254, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="string", length=11, nullable=false)
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime", nullable=false)
     */
    private $dateCreation;

    /**
     * @var string
     *
     * @ORM\Column(name="image_url", type="string", length=254, nullable=false)
     */
    private $imageUrl;

    /**
     *
     * @ORM\ManyToOne(targetEntity="State")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_state", referencedColumnName="id_state")
     * })
     */
    private $State;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Type")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_type", referencedColumnName="id_type")
     * })
     */
    private $Type;

    /**
     * Set quantity
     *
     * @param int $quantity
     */

    public function __construct()
    {
        $this->dateCreation= new \DateTime();
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Set idProduct
     *
     * @param int $idProduct
     */
    public function setIdProduct($idProduct)
    {
        $this->idProduct = $idProduct;
    }

    /**
     * Set imageUrl
     *
     * @param string $imageUrl
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }


    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Set price
     *
     * @param string $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get idProduct
     *
     * @return int
     */
    public function getIdProduct()
    {
        return $this->idProduct;
    }



    /**
     * Get imageUrl
     *
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }



    /**
     * Set state
     *
     * @param \Projet\BurgerBundle\Entity\State $state
     *
     * @return Product
     */
    public function setState(\Projet\BurgerBundle\Entity\State $state = null)
    {
        $this->State = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return \Projet\BurgerBundle\Entity\State
     */
    public function getState()
    {
        return $this->State;
    }

    /**
     * Set type
     *
     * @param \Projet\BurgerBundle\Entity\Type $type
     *
     * @return Product
     */
    public function setType(\Projet\BurgerBundle\Entity\Type $type = null)
    {
        $this->Type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Projet\BurgerBundle\Entity\Type
     */
    public function getType()
    {
        return $this->Type;
    }









    private $file;

    public function setFile(UploadedFile $file)
    {
        $this->file= $file;

        return $this;
    }

    public function getFile()
    {
        return  $this->file;
    }

}
