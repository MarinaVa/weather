<?php
namespace App\Http\Controllers;

use App\City;
use App\Weather;
use App\Components\WeatherMap;
use Cmfcmf\OpenWeatherMap\Exception as OWMException;
use Illuminate\Http\Request as Request;
use Session;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::getList();
        return view('cities.index', ['cities' => $cities]);
    }
    
    public function save(Request $request)
    {   
        $this->validate($request, [
            'city_name' => 'required',
        ]);

        $alertType= 'alert-danger';
        $alertMessage = '';
        
        try {
            $cityName = $request->get('city_name');
            
            $currentWeather = (new WeatherMap())->getByCityName($cityName);
            
            if(empty($currentWeather->city->id)) {
                $alertMessage = 'The city is not found';
            } else {
                
                if(Weather::saveCurrentCityWeather($cityName, $currentWeather)) {
                    $alertType = 'alert-success';
                    $alertMessage = 'The Weather for the city has been successfully saved';
                } else {
                    $alertMessage = 'An error occurred while saving weather data';
                }
            }    
        } catch(OWMException $e) {
            $alertMessage = 'OpenWeatherMap exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
        } catch(\Exception $e) {
            $alertMessage = 'General exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
        }

        Session::flash('message', $alertMessage); 
        Session::flash('alert-class', $alertType); 
        return redirect()->action('CityController@index');
    }        
}