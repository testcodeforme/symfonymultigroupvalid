<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

//use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="cart")
 */
class Cart
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Item[]|Collection
     * @ORM\OneToMany(targetEntity="Item", mappedBy="cart", cascade={"persist"})
     * @ORM\JoinColumn(name="cart_id", referencedColumnName="id", nullable=false)
     * asdAssert\Valid
     */
    private $items;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     * @Assert\NotBlank(groups={"observation"})
     * @Assert\Length(
     *      min = 4,
     *      max = 200,
     *      groups={"observation"}
     * )
     */
    private $observation;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     * @Assert\NotBlank(groups={"observationExtra"})
     * @Assert\Length(
     *      min = 4,
     *      max = 200,
     *      groups={"observationExtra"}
     * )
     */
    private $observationExtra;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId() : ?int
    {
        return $this->id;
    }

    /**
     * @return Item[]|ArrayCollection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param Item $item
     *
     * @return self
     */
    public function addItem(Item $item) : self
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setCart($this);
        }
        return $this;
    }

    /**
     * @param Item $item
     *
     * @return self
     */
    public function removeItem(Item $item) : self
    {
        $this->items->removeElement($item);
        return $this;
    }


    /**
     * @return string
     */
    public function getObservation() : ?string
    {
        return $this->observation;
    }

    /**
     * @param string $observation
     *
     * @return self
     */
    public function setObservation($observation) : self
    {
        $this->observation = $observation;
        return $this;
    }

    /**
     * @return string
     */
    public function getObservationExtra() : ?string
    {
        return $this->observationExtra;
    }

    /**
     * @param string $observationExtra
     *
     * @return self
     */
    public function setObservationExtra($observationExtra) : self
    {
        $this->observationExtra = $observationExtra;
        return $this;
    }

}