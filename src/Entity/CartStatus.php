<?php

declare(strict_types=1);
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class CartStatus
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    private $id;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $statusDescription;

    /**
     * @return int
     */

    /**
     * @var string
     * @ORM\OneToMany(targetEntity=Cart::class, mappedBy="cartStatus")
     */
    private $cart;
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getStatusDescription(): string
    {
        return $this->statusDescription;
    }

    /**
     * @param string $statusDescription
     */
    public function setStatusDescription(string $statusDescription): void
    {
        $this->statusDescription = $statusDescription;
    }

}