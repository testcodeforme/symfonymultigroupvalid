<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="item")
 */
class Item
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
     * @Assert\NotBlank(groups={"CountryValid"})
     * @Assert\Valid(groups={"CountryValid"})
     * @ORM\ManyToOne(targetEntity="Country")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id", nullable=false)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     * @Assert\NotBlank(groups={"Information"})
     * @Assert\Length(
     *      min = 4,
     *      max = 200,
     *      groups={"Information"}
     * )
     */
    private $info;

    /**
     * @ORM\ManyToOne(targetEntity="Cart", inversedBy="items")
     * @ORM\JoinColumn(name="cart_id", referencedColumnName="id", nullable=false)
     */
    private $cart;

    /**
     * @return int
     */
    public function getId() : ?int
    {
        return $this->id;
    }

    /**
     * @return Cart
     */
    public function getCart() : ?Cart
    {
        return $this->cart;
    }

    /**
     * @param Cart $cart
     *
     * @return self
     */
    public function setCart(Cart $cart) : self
    {
        $this->cart = $cart;
        return $this;
    }


    /**
     * @return string
     */
    public function getInfo() : ?string
    {
        return $this->info;
    }

    /**
     * @param string $info
     *
     * @return self
     */
    public function setInfo($info) : self
    {
        $this->info = $info;
        return $this;
    }

    /**
     * @return Country
     */
    public function getCountry() : ?Country
    {
        return $this->country;
    }

    /**
     * @param Country $country
     *
     * @return self
     */
    public function setCountry(Country $country) : self
    {
        $this->country = $country;
        return $this;
    }

}