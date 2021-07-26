<?php

namespace App\Controller;

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
                . '<a href="' . $this->generateUrl('pizza_edit', ['id' => $pizza->getId()]) . '">edit</a>'
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
    
    public function delete(int $id): Response {
        /** @var Pizza $pizza */
        $pizza = $this->getDoctrine()->getRepository(Pizza::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($pizza);
        $entityManager->flush();
        
        return $this->redirect($this->generateUrl('pizzas'));
    }
}
