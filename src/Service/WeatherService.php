<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

class WeatherService
{
    private $client;
    private $apiKey;

    public function __construct($apiKey)
    {
        $this->client = HttpClient::create();
        $this->apiKey = $apiKey;
    }


    public function getWeather()
    {
        try{
            $response = $this->client->request('GET', 'https://api.openweathermap.org/data/2.5/weather?lon=1.44&lat=43.6&appid=' . $this->apiKey);
            $data = $response->getContent();
            $data = $response->toArray();
        } catch (\Throwable $th) {
            return $th->getCode();
        }
        return $data;
    }
    public function getWeatherByCity(string $city)
    {
        try {
            $response = $this->client->request('GET', 
            'https://api.openweathermap.org/data/2.5/weather?q='.$city.'&appid='. $this->apiKey);
            $data = $response->getContent();
            $data = $response->toArray();
        } catch (\Throwable $th) {
           return $th->getCode();
        }
        return $data;
    }
    public function errorMessage(int $codeError){
        $info = "";
        if($codeError==404){
            $info = 'La ville choisie n\'existe pas  !';
            return $info;
        }
        if($codeError==401){
            $info = 'Désolé, la clée API n\'est plus valide !';
            return $info;
        }
        if($codeError==429){
            $info = 'Désolé, le nombre d\'appel API maximum a été atteint !';
            return $info;
        }
        else{
            $info = "Désolé, nous rencontrons une erreur $codeError !";
            return $info;
        }
    }
}