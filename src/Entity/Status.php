<?php

declare(strict_types=1);

namespace App\Entity;


use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Status
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
     * @ORM\Column
     * @Assert\Length(min=2)
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $inProgress;
        /**
     * @var string
     * @ORM\Column
     * @Assert\Length(min=2)
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $ready;
        /**
     * @var string
     * @ORM\Column
     * @Assert\Length(min=2)
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $take;

    /**
     * @return int
     */
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

    
}
