<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends AbstractController {
    public function index(): Response {
        
        $html = '<html><body>';
        $html .= '<a href="' . $this->generateUrl('ingredients') . '">Ingredients</a><br />';
        $html .= '<a href="' . $this->generateUrl('pizzas') . '">Pizzas</a><br />';
        $html .= '</body></html>';
        
        return new Response(
            $html
        );
    }
}
