<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ProductRepository;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;
    /**
     * @var string
     * @ORM\Column
     * @Assert\Length(min=2)
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $name;
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\GreaterThan(0)
     * @Assert\Type(type="int")
     */
    private $price;

    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products", cascade={"persist"}, fetch="LAZY")
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Customer", inversedBy="products", cascade={"persist", "refresh", "merge"})
     */
    private $responsible;

    public function __construct()
    {
        $this->responsible = new ArrayCollection();
    }

    /**
     * @return Category
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(?Category $category): void
    {
        $this->category = $category;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    /**
     * @return Collection|Customer[]
     */
    public function getResponsible(): Collection
    {
        return $this->responsible;
    }

    public function addResponsible(Customer $responsible): self
    {
        if (!$this->responsible->contains($responsible)) {
            $this->responsible[] = $responsible;
        }

        return $this;
    }

    public function removeResponsible(Customer $responsible): self
    {
        if ($this->responsible->contains($responsible)) {
            $this->responsible->removeElement($responsible);
        }

        return $this;
    }
}
