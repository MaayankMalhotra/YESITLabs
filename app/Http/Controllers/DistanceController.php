<?php



namespace App\Http\Controllers;


use Illuminate\Http\Request;
use League\Geotools\Coordinate\Coordinate;
use League\Geotools\Distance\Distance;
use League\Geotools\Geotools;

class DistanceController extends Controller
{

    public function index()
    {
        
        return view('geolocation');
    }
    public function getDistance(Request $request)
    {
        $lat1=$request->input('latitude_from');
        $long1=$request->input('longitude_from');
        $lat2=$request->input('latitude_to');
        $long2 = $request->input('longitude_to');

        $theta = $long1 - $long2;
        $miles = (sin(deg2rad($lat1))) * sin(deg2rad($lat2)) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $result['miles'] = $miles * 60 * 1.1515;
        $result['feet'] = $result['miles']*5280;
        $result['yards'] = $result['feet']/3;
        $result['kilometers'] = $result['miles']*1.609344;
        $result['meters'] = $result['kilometers']*1000;
        return $result;
    }
   
      
    
}
