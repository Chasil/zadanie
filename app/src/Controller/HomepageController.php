<?php

namespace App\Controller;

use App\Api\ApiClient;
use App\Entity\Weather;
use App\Form\TemperatureCalculatorType;
use App\Service\CoordinateFetcher;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(
        Request $request,
        ManagerRegistry $doctrine,
        CoordinateFetcher $coordinateFetcher,
        ApiClient $apiClient
        ): Response
    {
        $temperatureCalculatorForm = $this->createForm(TemperatureCalculatorType::class);

        $temperatureCalculatorForm->handleRequest($request);
        if($temperatureCalculatorForm->isSubmitted() && $temperatureCalculatorForm->isValid()) {

            $city = $temperatureCalculatorForm->get('city')->getData();
            $country = $temperatureCalculatorForm->get('country')->getData();

            $coordinates = $coordinateFetcher->get($city, $country);

            $apiClient->fetchAPIInformation($coordinates[0], $coordinates[1]);

            $entityWeather = new Weather();
            $entityWeather->setCity($city);
            $entityWeather->setCountry($country);
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
