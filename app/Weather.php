<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\City;

class Weather extends Model
{
    public $table = "weather";
    
    /**
     * Returns related data from City model
     */
    public function city() 
    {
        return $this->belongsTo('App\City');
    }
    
    /**
     * Saves current city weather
     * 
     * @param string $cityName
     * @param CurrentWeather $currentWeather
     * 
     * @return boolean
     */
    public static function saveCurrentCityWeather($cityName, $currentWeather)
    {
        $city = City::getByOwmId($currentWeather->city->id, $cityName);
       
        $weather = self::select()->where('city_id', $city->id)->first();
        if(!$weather) {
            $weather = new self();
        }
        
        $weather->city_id = $city->id;
        $weather->main = $currentWeather->weather;
        $weather->description = $currentWeather->weather->description;
        $weather->temperature = (float)$currentWeather->temperature->__toString();
        $weather->pressure = (float)$currentWeather->pressure->__toString();
        $weather->humidity = (int)$currentWeather->humidity->__toString();
        $weather->wind_speed = (float)$currentWeather->wind->speed->__toString();
        $weather->clouds = (int)$currentWeather->clouds->__toString();
                
        return $weather->save();
    }
}
