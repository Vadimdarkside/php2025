<?php

namespace App\Controller;

use App\Form\LoginType;
use App\Repository\ClientsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/api/login', name: 'login')]
    public function login(): Response
    {
        return $this->render('lab5/login.html.twig');
    }

}

