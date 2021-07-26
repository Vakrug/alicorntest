<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PizzaIngredient
 *
 * @ORM\Table(name="pizza_ingredient", indexes={@ORM\Index(name="FK_pizza_ingredient_pizza", columns={"PizzaId"}), @ORM\Index(name="FK_pizza_ingredient_ingredient", columns={"IngredientId"})})
 * @ORM\Entity
 */
class PizzaIngredient
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
     * @var \Ingredient
     *
     * @ORM\ManyToOne(targetEntity="Ingredient")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IngredientId", referencedColumnName="Id")
     * })
     */
    private $ingredientid;

    /**
     * @var \Pizza
     *
     * @ORM\ManyToOne(targetEntity="Pizza")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PizzaId", referencedColumnName="Id")
     * })
     */
    private $pizzaid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIngredientid(): ?Ingredient
    {
        return $this->ingredientid;
    }

    public function setIngredientid(?Ingredient $ingredientid): self
    {
        $this->ingredientid = $ingredientid;

        return $this;
    }

    public function getPizzaid(): ?Pizza
    {
        return $this->pizzaid;
    }

    public function setPizzaid(?Pizza $pizzaid): self
    {
        $this->pizzaid = $pizzaid;

        return $this;
    }


}
