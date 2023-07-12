<?php

namespace App\Controller;

use App\Form\TemperatureCalculatorType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(): Response
    {
        $temperatureCalculatorForm = $this->createForm(TemperatureCalculatorType::class);

        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
            'form' => $temperatureCalculatorForm
        ]);
    }
}
