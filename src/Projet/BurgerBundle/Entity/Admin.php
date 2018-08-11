<?php
/**
 * Created by PhpStorm.
 * User: ACER
 * Date: 8/11/2018
 * Time: 8:59 AM
 */

namespace Projet\BurgerBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Admin
 *
 * @ORM\Table(name="admin")
 * @ORM\Entity(repositoryClass="Projet\BurgerBundle\Repository\AdminRepository")
 */

class Admin
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_admin", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAdmin;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=254, nullable=false)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=254, nullable=false)
     */
    private $password;

    /**
     * Set login
     *
     * @param string $login
     */
    public function setDescription($login)
    {
        $this->login = $login;
    }

    /**
     * Set idAdmin
     *
     * @param int $idAdmin
     */
    public function setIdProduct($idAdmin)
    {
        $this->idAdmin = $idAdmin;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setName($password)
    {
        $this->password = $password;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Get idAdmin
     *
     * @return int
     */
    public function getIdAdmin()
    {
        return $this->idAdmin;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}