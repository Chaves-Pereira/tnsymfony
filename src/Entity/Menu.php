<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MenuRepository")
 * @UniqueEntity(fields="name", message="Ce nom existe déja.")
 */
class Menu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
    * @ORM\column(type="string", unique=true)
    * @Assert\Length(min=2, max=255, minMessage="Le nom du menu doit faire au moins {{ limit }} caratères")
    */
    private $name;

    /**
    * @ORM\ManyToMany(targetEntity="App\Entity\Link")
    * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
    * @Assert\Valid()
    */
    private $links;
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getLinks() {
        return $this->links;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setLinks($links) {
        $this->links = $links;
    }

    public function addLink($link) {
    	$this->links[] = $link;
    }

    public function removeLink($link) {

    }
}
