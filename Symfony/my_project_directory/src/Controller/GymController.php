<?php

namespace App\Controller;

use App\Repository\ClientsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
class GymController extends AbstractController
{
    #[Route('/', name:'index')]
    public function index():Response
    {
        return $this->render('lab3GymView/index.html.twig');
    }

}

