<?php

namespace App\Controller;

use App\Api\OpenMeteo\OpenMeteoApiClient;
use App\Api\OpenWeather\OpenWeatherApiClient;
use App\Api\WeatherParametersConverterTrait;
use App\Exception\AddressFailException;
use App\Exception\WeatherMissingException;
use App\Form\TemperatureCalculatorType;
use App\Service\CoordinateFetcher;
use App\Service\WeatherSaver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class HomepageController extends AbstractController
{
    use WeatherParametersConverterTrait;
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws AddressFailException
     * @throws RedirectionExceptionInterface
     * @throws WeatherMissingException
     * @throws ClientExceptionInterface
     */
    #[Route('/', name: 'app_homepage')]
    public function index(
        Request                         $request,
        CoordinateFetcher               $coordinateFetcher,
        WeatherSaver                    $weatherSaver,
        OpenWeatherApiClient            $openWeatherApiClient,
        OpenMeteoApiClient              $openMeteoApiClient
        ): Response
    {
        $temperatureCalculatorForm = $this->createForm(TemperatureCalculatorType::class);

        $temperatureCalculatorForm->handleRequest($request);
        if($temperatureCalculatorForm->isSubmitted() && $temperatureCalculatorForm->isValid()) {

            $city = $temperatureCalculatorForm->get('city')->getData();
            $country = $temperatureCalculatorForm->get('country')->getData();

            $coordinates = $coordinateFetcher->get($city, $country);

            $apiClientsList = [
                $openWeatherApiClient,
                $openMeteoApiClient
            ];

            $temperatures = [];
            foreach ($apiClientsList as $apiClient) {
                $apiData = $apiClient->fetchAPIInformation($coordinates['latitude'], $coordinates['longitude']);
                $temperatures[] = $apiData->getTemperature();
            }

            $averageTemperature = $this->getAverageTemperature(
                $temperatures
            );

            $weatherSaver->save($city, $country, $averageTemperature);

            $this->addFlash('notice', 'Average weather to ' . $city .', ' . $country .' is ' . $averageTemperature);
        }

        return $this->render('homepage/index.html.twig', [
            'form' => $temperatureCalculatorForm,
        ]);
    }
}
