<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
class GymController extends AbstractController
{
    #[Route('/gym', name:'index')]
    public function index():Response
    {
        return $this->render('lab3GymView/index.html.twig');
    }

}

