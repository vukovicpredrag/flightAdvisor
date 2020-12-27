<?php

namespace App\Http\Controllers;

use App\Airport;
use App\City;
use Illuminate\Http\Request;

class CityController extends Controller
{

    public function __construct()
    {

        $this -> middleware( 'auth' );

    }


    public function index( Request $request )
    {

        $cities = City::all();

        return view( 'user.cities.index', compact( 'cities'));

    }


    public function addCity( Request $request )
    {

        $name        = $request->name;
        $country     = $request->country;
        $description = $request->description;

        City::create([
            'name'        => $name,
            'country'     => $country,
            'description' => $description,
        ]);

        return redirect('/')->with('status', 'The city is successfully added.');

    }


    public function getList(Request $request)
    {

        $limit = 20;
        $city  = $request -> city;
        $airports = Airport::where('city', '!=', '')->offset(($city - 1) * $limit)->limit( $limit );

        if ( $request -> q && isset( $request -> q[ 'term' ] ) && $request -> q[ 'term' ] ) {

            $airports -> where( 'city', 'LIKE', "%" . $request -> q[ 'term' ] . "%" );

        }

        $airports = $airports->groupBy( ['city', 'country' ] )->get( ['id', 'city', 'country' ]);

        $result = [];

        foreach ( $airports as $key => $data ){

            $result[ $key ][ 'id' ] = $data[ 'city' ];
            $result[ $key ][ 'text' ] = $data[ 'city' ] . '  (' .$data[ 'country' ] . ')';

        }

        $data = new \stdClass();
        $data -> results = $result;

        return json_encode($data);

    }


    public function search(Request $request)
    {

        $cities     = City::all();
        $searchCity = $request->city;

        if ($searchCity && $searchCity!='all') {

            $cities = City::where( 'name', 'LIKE', "%{$searchCity}%" )-> get();

        }

        return view( 'user.cities.index', compact( 'cities'));

    }

}
