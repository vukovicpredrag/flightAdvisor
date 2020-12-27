<?php

namespace App\Http\Controllers;

use App\Helper\FlightFinder;
use App\Route;
use Illuminate\Http\Request;
use App\Helper\ImportData;
use Illuminate\Support\Facades\Validator;



class ImportDataController extends Controller
{


    public function __construct()
    {

        $this -> middleware( 'auth' );

    }


    static public function importData( Request $request )
    {

        $airportsFile = $request->file('airports');
        $routesFile   = $request->file('routes');

        if( !$airportsFile && !$routesFile ){

            return redirect('home')->withErrors('File missing!');

        }

        $validator = Validator::make($request->all(), [

            'airports' => 'mimes:txt',
            'routes' =>  'mimes:txt'

        ]);

        if ($validator->fails()) {

            return redirect('home')->withErrors($validator) ->withInput();
        }

        if( $request->file('airports') ) {

            $file = $request->file('airports');

            $fileName = 'airports-'.time().'.'.$file->getClientOriginalExtension();

            $file->storeAs('files', $fileName);

            ImportData::import($fileName, 'airports');


        }


        if( $request->file('routes') ) {

            $file = $request->file('routes');

            $fileName = 'routes-'.time().'.'.$file->getClientOriginalExtension();

            $file->storeAs('files', $fileName);

            ImportData::import($fileName, 'routes');


            //Save all routes to local json file
            $flightFinder = new FlightFinder();
            $routes = Route::select(['*', \DB::raw(('MIN(price) as min_price'))])->groupBy('source_airport_id', 'destination_airport_id' ) -> get();
            if($routes && $flightFinder) {

                foreach ($routes as $route) {
                    $flightFinder->addedge($route->source_airport_id, $route->destination_airport_id, $route->min_price);
                }

            $routesJson = json_encode( $flightFinder -> allNodes(), 1 );
            $file = public_path('json/routes.json');
            file_put_contents( $file, $routesJson );

            }

        }

        return redirect('/' )->with('status', 'File are successfully imported.');


    }

}
