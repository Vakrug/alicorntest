<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OrderBy;

/**
 * Pizza
 *
 * @ORM\Table(name="pizza")
 * @ORM\Entity
 */
class Pizza
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Name", type="string", length=255, nullable=false)
     */
    private $name;
    
    /**
     * @ManyToMany(targetEntity="Ingredient")
     * @JoinTable(name="pizza_ingredient",
     *      joinColumns={@JoinColumn(name="PizzaId", referencedColumnName="Id")},
     *      inverseJoinColumns={@JoinColumn(name="IngredientId", referencedColumnName="Id")}
     *      )
     * @OrderBy({"id" = "ASC"})
     */
    private $ingredients;
    
    public function __construct() {
        $this->ingredients = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    
    public function getIngredients() {
        return $this->ingredients;
    }
    
    public function addIngredient(Ingredient $ingredient): self {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients[] = $ingredient;
        }
        return $this;
    }
    
    public function removeIngredient(Ingredient $ingredient): self {
        if ($this->ingredients->contains($ingredient)) {
            $this->ingredients->removeElement($ingredient);
        }
        return $this;
    }

}
