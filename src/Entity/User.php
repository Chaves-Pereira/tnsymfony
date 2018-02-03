<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
    * @ORM\Column(type="string")
    * @Assert\Length(min=2, max=20, minMessage="Le nom d'utilisateur doit faire au moins {{ limit }} caratères", maxMessage="Le nom d'utilisateur doit faire au plus {{ limit }} caractères")
    */
    private $username;

    /**
    * @ORM\Column(type="string")
    * @Assert\Length(min=6, max=255, minMessage="Le mot de passe doit faire au moins {{ limit }} caratères", maxMessage="Le mot de passe doit faire au plus {{ limit}} caractères")
    */
    private $password;

    /**
    * @ORM\Column(type="string")
    */
    private $salt;

    /**
    * @ORM\Column(type="string")
    * @Assert\Email(message="Veuillez entrez un email valide")
    */
    private $mail;

    /**
    * @ORM\Column(type="array")
    */
    private $roles;

    public function getUsername() {
    	return $this->username;
    }

    public function setUsername($username) {
    	$this->username = $username;
    }

    public function getPassword() {
    	return $this->password;
    }

    public function setPassword($password) {
    	$this->password = $password;
    }

    public function getMail() {
    	return $this->mail;
    }

    public function setMail($mail) {
    	$this->mail = $mail;
    }

    public function getSalt() {
    	return $this->salt;
    }

    public function setSalt($salt) {
    	$this->salt = $salt;
    }
    
    public function addRole($role) {
    	$this->roles[] = $role;
    }

	public function getRoles() {
	    return $this->roles;
	}

    public function eraseCredentials() {

    }
}
