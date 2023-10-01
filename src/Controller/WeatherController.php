<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\WeatherService;
use Symfony\Component\Serializer\SerializerInterface;

class WeatherController extends AbstractController
{
    /**
     * @Route("/", name="weather")
     */
    public function index(WeatherService $weather,Request $request)
    {
        $meteo = "";
        $message = "";
        if($request->request->get('submit')){
            $recup = $request->request->get('city');
            if(empty($recup)){
                $message ='Veuillez Choisir une ville';
            }
            $meteo = $weather->getWeatherByCity($recup);
            if(is_int($meteo)){
                $message=  $weather->errorMessage($meteo);
            }
        }else{
            $meteo = $weather->getWeather();
            if(is_int($meteo)){
                $message = $weather->errorMessage($meteo);
            }
        }
        return $this->render('weather/index.html.twig', [
            'meteo'=>$meteo,
            'message'=>$message
        ]);
    }
   

}

