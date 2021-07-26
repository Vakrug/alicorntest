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
        
        $html = '<html><body>';
        $html .= '<a href="' . $this->generateUrl('index') . '">Home</a><br />';
        foreach ($ingredients as $ingredient) {
            $html .= $ingredient->getName() . ' - ' . $ingredient->getPrice() . ' '
                . '<a href="' . $this->generateUrl('ingredient_edit', ['id' => $ingredient->getId()]) . '">edit</a>'
                . '<form method="POST" action="' . $this->generateUrl('ingredient_delete', ['id' => $ingredient->getId()]) . '"><input type="submit" value="delete" /></form>'
                . '<br />';
        }
        $html .= '<a href="' . $this->generateUrl('ingredient_new') . '">new</a><br />';
        $html .= '</body></html>';
        
        return new Response(
            $html
        );
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
            
            return $this->redirect($this->generateUrl('ingredients'));
        }
        
        $html = '<html><body>';
        $html .= '<form method="POST"><input type="text" name="name" value="' . $ingredient->getName() . '" />';
        $html .= '<input type="number" name="price" step="any" value="' . $ingredient->getPrice() . '" />';
        $html .= '<input type="submit" value="submit" /></form>';
        $html .= '</body></html>';
        
        return new Response(
            $html
        );
    }
    
    public function new(Request $request): Response {
        
        if ($request->isMethod('POST')) {
            $ingredient = new Ingredient();
            $ingredient->setName($request->get('name'));
            $ingredient->setPrice($request->get('price'));
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ingredient);
            $entityManager->flush();
            
            return $this->redirect($this->generateUrl('ingredients'));
        }
        
        $html = '<html><body>';
        $html .= '<form method="POST"><input type="text" name="name" value="" />';
        $html .= '<input type="number" name="price" step="any" value="" />';
        $html .= '<input type="submit" value="submit" /></form>';
        $html .= '</body></html>';
        
        return new Response(
            $html
        );
    }
    
    public function delete(int $id): Response {
        /** @var Ingredient $ingredient */
        $ingredient = $this->getDoctrine()->getRepository(Ingredient::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($ingredient);
        $entityManager->flush();
        
        return $this->redirect($this->generateUrl('ingredients'));
    }
    
}
