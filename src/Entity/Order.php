<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $number;
    /**
     * @var string
     * @ORM\Column
     */
    private $status;
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Selection", mappedBy="myOrder", orphanRemoval=true)
     */
    private $selections;

    public function __construct()
    {
        $this->selections = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }

    /**
     * @param int $number
     */
    public function setNumber(int $number): void
    {
        $this->number = $number;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return Collection|Selection[]
     */
    public function getSelections(): Collection
    {
        return $this->selections;
    }

    public function addSelection(Selection $selection): self
    {
        if (!$this->selections->contains($selection)) {
            $this->selections[] = $selection;
            $selection->setMyOrder($this);
        }

        return $this;
    }

    public function removeSelection(Selection $selection): self
    {
        if ($this->selections->contains($selection)) {
            $this->selections->removeElement($selection);
            // set the owning side to null (unless already changed)
            if ($selection->getMyOrder() === $this) {
                $selection->setMyOrder(null);
            }
        }

        return $this;
    }
}
