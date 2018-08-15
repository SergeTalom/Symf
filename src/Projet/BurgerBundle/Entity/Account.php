<?php

namespace Projet\BurgerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Account
 *
 * @ORM\Table(name="account", indexes={@ORM\Index(name="FK_create", columns={"id_user"})})
 * @ORM\Entity
 */
class Account
{
    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=254, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=254, nullable=false)
     */
    private $password;

    /**
     *
     * @ORM\OneToOne(targetEntity="User",cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    /**
     *
     * @ORM\ManyToOne(targetEntity="State")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_state", referencedColumnName="id_state")
     * })
     */
    private $State;

    /**
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }



    /**
     * Set idUser
     *
     * @param \Projet\BurgerBundle\Entity\User $idUser
     *
     * @return Account
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

    /**
     * Set state
     *
     * @param \Projet\BurgerBundle\Entity\State $state
     *
     * @return Account
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
}
