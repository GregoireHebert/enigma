<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Cart
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    private $id;
    /**
     * @var Selection[]|Collection
     * @ORM\ManyToMany(targetEntity=Selection::class, cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinTable(
     *     joinColumns={@ORM\JoinColumn(name="cart_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="selection_id", referencedColumnName="id", unique=true)}
     * )
     */
    private $selections;
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $total = 0;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\State", inversedBy="carts")
     */
    private $state;

    public function __construct()
    {
        $this->selections = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Selection[]|Collection
     */
    public function getSelections()
    {
        return $this->selections;
    }

    /**
     * @param Selection[]|Collection $selection
     */
    public function setSelections($selections): void
    {
        $this->selections = $selections;
    }

    public function addSelection(Selection $selection): void
    {
        if (!$this->selections->contains($selection)) {
            $this->selections->add($selection);

            $this->total += $selection->getProduct()->getPrice() * $selection->getQuantity();
        }
    }

    public function removeSelection(Selection $selection): void
    {
        if ($this->selections->contains($selection)) {
            $this->total -= $selection->getProduct()->getPrice() * $selection->getQuantity();

            $this->selections->removeElement($selection);
        }
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @param int $total
     */
    public function setTotal(int $total): void
    {
        $this->total = $total;
    }

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(?State $state): self
    {
        $this->state = $state;

        return $this;
    }
}
