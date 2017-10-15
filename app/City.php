<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     * Returns related data from Weather model
     */
    public function weather() 
    {
        return $this->hasone('App\Weather');
    }
    
    /**
     * Returns city object by owm_id parameter
     * 
     * @param integer $owmId
     * @param string $cityName
     * 
     * @return City loaded model
     */
    public static function getByOwmId($owmId, $cityName)
    {
        $city = self::select()->where('owm_id', $owmId)->first();
         
        if(!$city) {
            $city = new City();
            $city->name = $cityName;
            $city->owm_id = $owmId;
            $city->save();
        }
        
        return $city;
    }
    
    /**
     * Returns cities list with current weather
     * 
     * @return array
     */
    public static function getList()
    {
        $cities = City::with('weather')->select(['id', 'name'])->get()->toArray();
        
        foreach($cities as &$city) {
    
            foreach($city['weather'] as $param => $value) {
                if(in_array($param, ['id', 'city_id'])) {
                    continue;
                }
                $city[] = $value;
            }
            unset($city['weather']);
        }
        
        return $cities;
    }
}
