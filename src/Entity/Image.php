<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
    * @ORM\Column(type="string")
    */
    private $url;

    /**
    * @ORM\Column(type="string")
    */
    private $alt;

    /**
    * @Assert\Image()
    */
    private $file;

    private $tempFilename;
    
    public function getId() {
        return $this->id;
    }

    public function getUrl() {
        return $this->url;
    }

    public  function getAlt() {
        return $this->alt;
    }

    public function getFile() {
        return $this->file;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function setAlt($alt) {
        $this->alt = $alt;
    }

    public function setFile(UploadedFile $file = null) {
        $this->file = $file;

        if (null !== $this->url) {
        	$this->tempFilename = $this->url;

        	$this->url = null;
        	$this->alt = null;
        }
    }

    /**
    * @ORM\PostPersist()
    * @ORM\PostUpdate()
    */
    public function upload() {
    	if (null === $this->file) {
    		return;
    	}

    	if (null !== $this->tempFilename) {
    		$oldFile = $this->getUploadRootDir() . '/' . $this->id .'.' . $this->tempFilename;
    		if (file_exists($oldFile)) {
    			unlink($oldFile);
    		}
    	}
    	
    	$this->file->move($this->getUploadRootDir(), $this->id . '.' . $this->url);
    }

    public function getUploadDir() {
    	return '/images';
    }

    public function getUploadRootDir() {
    	return __DIR__ . '/../../public' . $this->getUploadDir();
    }

    /**
    * @ORM\PrePersist()
    * @ORM\PreUpdate()
    */
    public function preUpload() {
    	if (null === $this->file) {
    		return;
    	}

    	$this->url = $this->file->guessExtension();

    	$this->alt = $this->file->getClientOriginalName();
    }

    /**
    * @ORM\PreRemove()
    */
    public function preRemoveUpload() {
    	$this->tempFilename = $this->getUploadRootDir() . '/' . $this->id . '.' . $this->url;
    }

    /**
    * @ORM\PostRemove()
    */
    public function removeUpload() {
    	if (file_exists($this->tempFilename)) {
    		unlink($this->tempFilename);
    	}
    }

    public function getWebPath() {
    	return $this->getUploadDir() . '/' . $this->getId() . '.' . $this->getUrl();
    }

    public function getName() {
    	return $this->id . '.' . $this->url;
    }
}
