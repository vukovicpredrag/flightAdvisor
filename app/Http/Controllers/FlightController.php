<?php

namespace App\Http\Controllers;

use App\Airport;
use App\Route;
use Illuminate\Http\Request;
use App\Helper\FlightFinder;


class FlightController extends Controller
{

    public function __construct()
    {

        $this -> middleware( 'auth' );

    }

    public function index()
    {

        return view('user.flight.index');

    }


    public function findFlight(Request $request)
    {

        $startCity = $request->cityFrom;
        $finalCity = $request->cityTo;

        $airportFrom = Airport::where('city', $startCity)->first();
        $airportTo   = Airport::where('city', $finalCity)->first();

        if(!$airportFrom || !$airportTo){

            $noFlight = 1;

            return view('user.flight.index',  compact('airportFrom', 'airportTo', 'noFlight' ));

        }

        //Get all airports from same city
        $startCityAirports = Airport::where('city', $airportFrom -> city)->where('country', $airportFrom->country)->pluck('airport_id');
        $finalCityAirports = Airport::where('city', $airportTo -> city)->where('country', $airportTo->country)->pluck('airport_id');

        $potentialRoutes = [];

        //Combine all source and destination airports
        foreach ($startCityAirports as $startAirport){

            foreach ($finalCityAirports as $finalAirport){

                $foundRoute = new FlightFinder();
                $route = $foundRoute->start($startAirport, $finalAirport );

                if($route){

                    $potentialRoutes[] = $foundRoute->start($startAirport, $finalAirport );

                }

            }

        }

        $cheapestRoutes =[];

        foreach ($potentialRoutes as $potentialRoute){

            $price  = [];
            $routes = [];

            foreach ($potentialRoute as $route){

                $route    = Route::find($route);
                $price[]  = $route -> price;
                $routes[] = $route;

            }

            $cheapestRoutes[array_sum($price)] = $routes;
        }


        ksort($cheapestRoutes);

        if (count($cheapestRoutes)) {

                $cheapestRoutes = array_values($cheapestRoutes)[0];

        }else{

                $noFlight = 1;

                return view('user.flight.index',  compact('airportFrom', 'airportTo', 'noFlight' ));

        }


        foreach ($cheapestRoutes as $route){

            $prices[]   = $route->price;
            $distance[] = $route->distance($route->sourceAirport->latitude, $route->sourceAirport->lognitude, $route->destinationAirport->latitude, $route->destinationAirport->lognitude);
        }

        $priceSum    = array_sum($prices);
        $distanceSum = round(array_sum($distance));


        return view('user.flight.index', compact('cheapestRoutes', 'airportFrom', 'airportTo', 'priceSum', 'distanceSum'));


    }

}
