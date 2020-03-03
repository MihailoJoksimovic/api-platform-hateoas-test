<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     itemOperations={
 *          "get"
 *     },
 *     collectionOperations={
 *          "copy"={
 *              "method"="POST",
 *              "path"="/cheese?from={id}/{action}",
 *              "parameters"={
 *                  "id" = "expr(object.id())"
 *              }
 *          },
 *          "get"
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\CheeseRepository")
 */
class Cheese
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
