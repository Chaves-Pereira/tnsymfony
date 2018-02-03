<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 */
class Location
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
    * @ORM\Column(type="string", length=255)
    */
    private $name;

    /**
    * @ORM\Column(type="string", length=255)
    */
    private $country;

    /**
    * @ORM\Column(type="string", length=255)
    */
    private $town;

    /**
    * @ORM\Column(type="string", length=255)
    */
    private $adress;

    /**
    * @ORM\Column(type="string", length=255)
    */
    private $postal;
}
