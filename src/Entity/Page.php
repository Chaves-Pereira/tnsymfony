<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PageRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Page
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
  
    /**
	* @ORM\Column(type="string")
    * @Assert\Length(min=2, max=255, minMessage="Le titre au faire au moins {{ limit }} caractère", maxMessage="Le titre doit faire au plus {{ limit }} caractères")
	*/
    private $title;

	/**
	* @ORM\Column(type="text")
    * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
	*/
    private $content;

    /**
	* @ORM\Column(type="boolean")
	*/
    private $published;

    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\User")
    * @Assert\Valid
    */
    private $author;

    /**
    * @ORM\Column(type="datetime")
    * @Assert\Date()
    */

    private $dateCreate;

    /**
    * @ORM\Column(type="datetime", nullable=true)
    * @Assert\Date()
    */
    private $dateUpdate;

    /**
    * @ORM\ManyToMany(targetEntity="App\Entity\Category", inversedBy="pages")
    * @ORM\JoinColumn(nullable=true)
    * @Assert\Valid()
    */
    private $categories;

    /**
    * @Gedmo\Slug(fields={"title"})
    * @ORM\Column(type="string", length=255, unique=true)
    * @Assert\Length(min=2, max=255, minMessage="Le titre au faire au moins {{ limit }} caractère", maxMessage="Le titre doit faire au plus {{ limit }} caractères")
    */
    private $slug;

    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\Image")
    * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
    * @Assert\Valid()
    */
    private $image;

    public function __construct() {
    	$this->categories = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getContent() {
        return $this->content;
    }

    public function getPublished() {
        return $this->published;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function setPublished($published) {
        $this->published = $published;
    }

    public function addCategory($category) {
    	$this->categories[] = $category;
        $category->addPage($this);
    }

    public function removeCategory($category) {
    	$this->categories->removeElement($category);
    }

    public function getCategories() {
    	return $this->categories;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function setAuthor($author) {
        $this->author = $author;
    }

    public function getDateCreate() {
        return $this->dateCreate;
    }

    public function setDateCreate($date) {
        $this->dateCreate = $date;
    }

    public function getDateUpdate() {
        return $this->dateUpdate;
    }

    public function setDateUpdate($date) {
        $this->dateUpdate = $date;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function setSlug($slug) {
        $this->slug = $slug;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    /**
    * @ORM\PreUpdate
    */
    public function setUpdated() {
        $this->dateUpdate = new \DateTime();
    }
}

