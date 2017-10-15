<?php

namespace App\Components;

use Cmfcmf\OpenWeatherMap;

class WeatherMap {
    private $_owm;
    private $_owmApiKey;
    private $_lang = 'en';
    private $_units = 'metric';
    
    /**
     * Creates OpenWeatherMap object and sets the api key
     */
    public function __construct()
    {
        $this->_owmApiKey = config('app.owm.apiKey');
        $this->_owm = new OpenWeatherMap($this->_owmApiKey);
    }
    
    /**
     * Returns current weather by city name
     * 
     * @param string $cityName
     * 
     * @return CurrentWeather The weather object
     */
    public function getByCityName($cityName)
    {
        return $this->_owm->getWeather($cityName, $this->_units, $this->_lang);
    }
}
