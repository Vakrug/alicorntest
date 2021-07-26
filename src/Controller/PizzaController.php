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
        
        $html = '<html><body>';
        $html .= '<a href="' . $this->generateUrl('index') . '">Home</a><br />';
        foreach ($pizzas as $pizza) {
            $html .= $pizza->getName() . ' '
                . '<a href="' . $this->generateUrl('pizza_edit', ['id' => $pizza->getId()]) . '">edit</a> - '
                . '<a href="' . $this->generateUrl('pizza_ingredients', ['id' => $pizza->getId()]) . '">ingredients</a>'
                . '<form method="POST" action="' . $this->generateUrl('pizza_delete', ['id' => $pizza->getId()]) . '"><input type="submit" value="delete" /></form>'
                . '<br />';
        }
        $html .= '<a href="' . $this->generateUrl('pizza_new') . '">new</a><br />';
        $html .= '</body></html>';
        
        return new Response(
            $html
        );
    }
    
    public function edit(int $id, Request $request): Response {
        /** @var Pizza $pizza */
        $pizza = $this->getDoctrine()->getRepository(Pizza::class)->find($id);
        
        
        if ($request->isMethod('POST')) {
            $pizza->setName($request->get('name'));
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pizza);
            $entityManager->flush();
            
            return $this->redirect($this->generateUrl('pizzas'));
        }
        
        $html = '<html><body>';
        $html .= '<form method="POST"><input type="text" name="name" value="' . $pizza->getName() . '" />';
        $html .= '<input type="submit" value="submit" /></form>';
        $html .= '</body></html>';
        
        return new Response(
            $html
        );
    }
    
    public function new(Request $request): Response {
        
        if ($request->isMethod('POST')) {
            $pizza = new Pizza();
            $pizza->setName($request->get('name'));
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pizza);
            $entityManager->flush();
            
            return $this->redirect($this->generateUrl('pizzas'));
        }
        
        $html = '<html><body>';
        $html .= '<form method="POST"><input type="text" name="name" value="" />';
        $html .= '<input type="submit" value="submit" /></form>';
        $html .= '</body></html>';
        
        return new Response(
            $html
        );
    }
    
    public function delete(int $id, Request $request): Response {
        if ($request->isMethod('POST')) {
            /** @var Pizza $pizza */
            $pizza = $this->getDoctrine()->getRepository(Pizza::class)->find($id);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pizza);
            $entityManager->flush();   
        }
        
        return $this->redirect($this->generateUrl('pizzas'));
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
        
        $html = '<html><body><a href="' . $this->generateUrl('index') . '">Home</a><br /><table>';
        $html .= '<tr>';
        $html .= '<th>Available</th>';
        $html .= '<th>Used</th>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>';
        foreach ($availableIngredients as $availableIngredient) {
            $html .= $availableIngredient->getName() . ' ' . $availableIngredient->getPrice()
                . '<form method="POST" action="' . $this->generateUrl('pizza_ingredient_add', ['pizzaid' => $pizza->getId(), 'ingredientid' => $availableIngredient->getId()]) . '"><input type="submit" value="add" /></form>'
                . '<br />';
        }
        $html .= '</td>';
        $html .= '<td>';
        $price = 0;
        foreach ($ingredients as $ingredient) {
            $html .= $ingredient->getName() . ' ' . $ingredient->getPrice()
                . '<form method="POST" action="' . $this->generateUrl('pizza_ingredient_remove', ['pizzaid' => $pizza->getId(), 'ingredientid' => $ingredient->getId()]) . '"><input type="submit" value="remove" /></form>'
                . '<br />';
            $price += $ingredient->getPrice();
        }
        $html .= 'ingredient price: ' . $price . '<br />';
        $html .= 'total price (+50%): ' . $price * 1.5 . '<br />';
        $html .= '</td>';
        $html .= '</tr>';
        $html .= '</table></body></html>';
        
        return new Response(
            $html
        );
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
        
        return $this->redirect($this->generateUrl('pizza_ingredients', ['id' => $pizzaid]));
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
        
        return $this->redirect($this->generateUrl('pizza_ingredients', ['id' => $pizzaid]));
    }
}
