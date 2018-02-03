<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
    * @ORM\Column(type="string", length=255, unique=true)
    */
    private $name;

    /**
    * @ORM\ManyToMany(targetEntity="App\Entity\Page", mappedBy="categories")
    * @ORM\JoinColumn(nullable=true)
    */
    private $pages;

    public function __construct() {
      $this->pages = new ArrayCollection();
    }

    public function getId() {
    	return $this->id;
  	}

  	public function setName($name){
  		$this->name = $name;
 	 }

  	public function getName() {
  		return $this->name;
  	}

    public function getPages() {
      return $this->pages;
    }

    public function setPages($pages) {
      $this->pages = $pages;
    }

    public function addPage($page) {
      $this->pages[] = $page;
    }

    public function removePage($page) {
      $this->pages->RemoveElement($page);
    }
}
