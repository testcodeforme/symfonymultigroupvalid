<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="country")
 */
class Country
{
    ///////////////
    // ATRIBUTOS //
    ///////////////

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=80, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=2, unique=true)
     */
    private $iso;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", options={"default":1})
     * @Assert\Choice(
     *     {1},
     *     groups={"CountryValid"},
     * )
     */
    private $estatus;

 
    /////////////////////
    // GETTER - SETTER //
    /////////////////////

    /**
     * @return int
     */
    public function getId() : ?int
    {
        return $this->id;
    }


    /**
     * @param int $id
     *
     * @return self
     */
    public function setId(int $id) : self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName() : ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName($name) : self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getIso() : ?string
    {
        return $this->iso;
    }

    /**
     * @param string $iso
     *
     * @return self
     */
    public function setIso($iso) : self
    {
        $this->iso = $iso;
        return $this;
    }

        /**
     * @return int
     */
    public function getEstatus() : ?int
    {
        return $this->estatus;
    }

    /**
     * @param int $estatus
     *
     * @return self
     */
    public function setEstatus($estatus) : self
    {
        $this->estatus = $estatus;
        return $this;
    }
}