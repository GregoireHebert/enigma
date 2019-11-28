<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderStatusRepository")
 */
class OrderStatus
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cart", mappedBy="orderStatus")
     */
    private $carts;

    public function __construct()
    {
        $this->carts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|Cart[]
     */
    public function getCart(): Collection
    {
        return $this->cart;
    }

    public function addCart(Cart $cart): self
    {
        if (!$this->cart->contains($cart)) {
            $this->cart[] = $cart;
            $cart->setOrderStatus($this);
        }

        return $this;
    }

    public function removeCart(Cart $cart): self
    {
        if ($this->cart->contains($cart)) {
            $this->cart->removeElement($cart);
            // set the owning side to null (unless already changed)
            if ($cart->getOrderStatus() === $this) {
                $cart->setOrderStatus(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Cart[]
     */
    public function getCarts(): Collection
    {
        return $this->carts;
    }
}
