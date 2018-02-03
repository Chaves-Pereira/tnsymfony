<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LinkRepository")
 */
class Link
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
    * @ORM\Column(type="string")
    * @Assert\Length(min=2, max=255, minMessage="Le nom doit faire au moins {{ limit }} caratères", maxMessage="Le nom doit faire au plus {{ limit }} caractères")
    */
    private $name;

    /**
    * @ORM\Column(type="string")
    */
    private $url;

    public function getName() {
    	return $this->name;
    }

    public function setName($name) {
    	$this->name = $name;
    }

    public function getUrl() {
    	return $this->url;
    }

    public function setUrl($url) {
    	$this->url = $url;
    }
}
