<?php

namespace App\Controller;

use App\Entity\Ingredient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IngredientController extends AbstractController {
    
    public function index(): Response {
        /** @var Ingredient[] $ingredients */
        $ingredients = $this->getDoctrine()->getRepository(Ingredient::class)->findAll();
        return $this->json($ingredients);
    }
    
    public function edit(int $id, Request $request): Response {
        /** @var Ingredient $ingredient */
        $ingredient = $this->getDoctrine()->getRepository(Ingredient::class)->find($id);
        
        
        if ($request->isMethod('POST')) {
            $ingredient->setName($request->get('name'));
            $ingredient->setPrice($request->get('price'));
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ingredient);
            $entityManager->flush();
            
            return $this->json(['success' => true]);
        }

        return $this->json($ingredient);
    }
    
    public function new(Request $request): Response {
        
        if ($request->isMethod('POST')) {
            $ingredient = new Ingredient();
            $ingredient->setName($request->get('name'));
            $ingredient->setPrice($request->get('price'));
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ingredient);
            $entityManager->flush();
            
            return $this->json(['success' => true]);
        }

        $ingredient = new Ingredient();
        return $this->json($ingredient);
    }
    
    public function delete(int $id): Response {
        /** @var Ingredient $ingredient */
        $ingredient = $this->getDoctrine()->getRepository(Ingredient::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($ingredient);
        $entityManager->flush();
        
        return $this->json(['success' => true]);
    }
    
}
