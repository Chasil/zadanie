<?php

namespace App\Controller;

use App\Entity\Weather;
use App\Form\TemperatureCalculatorType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $temperatureCalculatorForm = $this->createForm(TemperatureCalculatorType::class);

        $temperatureCalculatorForm->handleRequest($request);
        if($temperatureCalculatorForm->isSubmitted() && $temperatureCalculatorForm->isValid()) {

            $entityWeather = new Weather();
            $entityWeather->setCity($temperatureCalculatorForm->get('city')->getData());
            $entityWeather->setCountry($temperatureCalculatorForm->get('country')->getData());
            $entityWeather->setAverageTemperature(12);
            $entityWeather->setAdded(new \DateTimeImmutable());

            $em = $doctrine->getManager();
            $em->persist($entityWeather);
            $em->flush();

            $this->addFlash('notice', 'Stored successfully');

        }

        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
            'form' => $temperatureCalculatorForm
        ]);
    }
}
