<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Entity\Pizza;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PizzaController extends AbstractController {
    
    public function index(): Response {
        /** @var Pizza[] $pizzas */
        $pizzas = $this->getDoctrine()->getRepository(Pizza::class)->findAll();
        return $this->json($pizzas);
    }
    
    public function edit(int $id, Request $request): Response {
        /** @var Pizza $pizza */
        $pizza = $this->getDoctrine()->getRepository(Pizza::class)->find($id);
        
        if ($request->isMethod('POST')) {
            $pizza->setName($request->get('name'));
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pizza);
            $entityManager->flush();
            
            return $this->json(['success' => true]);
        }

        return $this->json($pizza);
    }
    
    public function new(Request $request): Response {
        
        if ($request->isMethod('POST')) {
            $pizza = new Pizza();
            $pizza->setName($request->get('name'));
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pizza);
            $entityManager->flush();
            
            return $this->json(['success' => true]);
        }

        $pizza = new Pizza();
        return $this->json($pizza);
    }
    
    public function delete(int $id, Request $request): Response {
        if ($request->isMethod('POST')) {
            /** @var Pizza $pizza */
            $pizza = $this->getDoctrine()->getRepository(Pizza::class)->find($id);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pizza);
            $entityManager->flush();   
        }
        
        return $this->json(['success' => true]);
    }
    
    public function ingredients(int $id): Response {
        /** @var Pizza $pizza */
        $pizza = $this->getDoctrine()->getRepository(Pizza::class)->find($id);
        /** @var Ingredient[] $ingredients */
        $ingredients = $pizza->getIngredients();
        /** @var Ingredient[] $possibleIngredients */
        $possibleIngredients = $this->getDoctrine()->getRepository(Ingredient::class)->findAll();
        /** @var Ingredient[] $availableIngredients */
        $availableIngredients = [];
        foreach ($possibleIngredients as $possibleIngredient) {
            $found = false;
            foreach ($ingredients as $ingredient) {
                if ($possibleIngredient->getId() == $ingredient->getId()) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $availableIngredients[] = $possibleIngredient;
            }
        }

        return $this->json([
            'pizza' => $pizza,
            'ingredients' => $ingredients,
            'availableIngredients' => $availableIngredients
        ]);
    }
    
    public function addIngredient(int $pizzaid, int $ingredientid, Request $request): Response {
        if ($request->isMethod('POST')) {
            /** @var Pizza $pizza */
            $pizza = $this->getDoctrine()->getRepository(Pizza::class)->find($pizzaid);
            /** @var Ingredient $ingredient */
            $ingredient = $this->getDoctrine()->getRepository(Ingredient::class)->find($ingredientid);

            $pizza->addIngredient($ingredient);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pizza);
            $entityManager->flush();
        }
        
        return $this->json(['success' => true]);
    }
    
    public function removeIngredient(int $pizzaid, int $ingredientid, Request $request): Response {
        if ($request->isMethod('POST')) {
            /** @var Pizza $pizza */
            $pizza = $this->getDoctrine()->getRepository(Pizza::class)->find($pizzaid);
            /** @var Ingredient $ingredient */
            $ingredient = $this->getDoctrine()->getRepository(Ingredient::class)->find($ingredientid);
            
            $pizza->removeIngredient($ingredient);
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pizza);
            $entityManager->flush();
        }
        
        return $this->json(['success' => true]);
    }
}
