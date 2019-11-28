<?php


namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CartStatus
 * @package App\Entity
 *
 * @ORM\Entity()
 */
class CartStatus
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var int
     * @ORM\Column
     * @Assert\Type(type="integer")
     * @Assert\NotBlank
     */
    private $level;

    /**
     * @var string
     * @ORM\Column
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(min="2")
     */
    private $name;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @param int $level
     */
    public function setLevel(int $level): void
    {
        $this->level = $level;
    }

    /**
     * @return string
     */
    public function getName(): string
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